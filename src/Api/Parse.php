<?php
/**
 * Pi Engine (http://piengine.org)
 *
 * @link            http://code.piengine.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://piengine.org
 * @license         http://piengine.org/license.txt New BSD License
 */

/**
 * @author Hossein Azizabadi <azizabadi@faragostaresh.com>
 */
namespace Module\Reader\Api;

use Pi;
use Pi\Application\Api\AbstractApi;
use Zend\Feed\Reader\Reader as ZendReader;
use Zend\Feed\Exception\Reader\RuntimeException as ZendRuntimeException;
use Zend\Http\Client as HttpClient;
use Zend\Json\Json;

/*
 * Pi::api('parse', 'reader')->doParse();
 */

class Parse extends AbstractApi
{
    public function doParse()
    {
        // Set result
        $result = array(
            'message' => '',
            'status' => 0,
            'time' => time(),
        );
        // Set custom HttpClient
        $config = array(
            'adapter' => 'Zend\Http\Client\Adapter\Curl',
        );
        $client = new HttpClient(null, $config);
        // Set zend feed reader setting
        ZendReader::registerExtension('Syndication');
        ZendReader::setHttpClient($client);
        // Get list of source
        $where = array('status' => 1);
        $order = array('id DESC');
        $select = Pi::model('source', $this->getModule())->select()->where($where)->order($order);
        $rowSet = Pi::model('source', $this->getModule())->selectWith($select);
        // Prossees source list
        foreach ($rowSet as $source) {
            // Set new update time
            $updateTime = $source->time_parse_last + $source->time_parse_period;
            // Check can update
            if (time() > $updateTime) {
                // import rss feed data
                $rss = ZendReader::import($source->link);
                // Set date
                $data = array(
                    'title' => _escape($rss->getTitle()),
                    'link' => _escape($rss->getLink()),
                    'description' => _escape($rss->getDescription()),
                    'language' => _escape($rss->getLanguage()),
                    'id' => _escape($rss->getId()),
                    'feedLink' => _escape($rss->getFeedLink()),
                    'generator' => _escape($rss->getGenerator()),
                    'copyright' => _escape($rss->getCopyright()),
                    'encoding' => _escape($rss->getEncoding()),
                    'type' => _escape($rss->getType()),
                    'updatePeriod' => _escape($rss->getUpdatePeriod()),
                );
                // Check and Set dateModified
                $dateModified = $rss->getDateModified();
                if (isset($dateModified) && !empty($dateModified)) {
                    $data['dateModified'] = $dateModified;
                }
                // Check and Set image
                $image = $rss->getImage();
                if (isset($image) && !empty($image)) {
                    $data['image'] = $image;
                }
                // Set feed entry date
                $i = 1;
                foreach ($rss as $entry) {
                    // Set description
                    $description = $entry->getDescription();
                    $description = _strip($description);
                    $description = strtolower(trim($description));
                    $description = preg_replace('/[\s]+/', ' ', $description);
                    // Set entry list data
                    $entryList[$i] = array(
                        'title'        => _escape($entry->getTitle()),
                        'description'  => $description,
                        'dateModified' => Json::encode($entry->getDateModified()),
                        'link'         => _escape($entry->getLink()),
                        'status'       => 1,
                        'time_create'  => time(),
                        'source'       => $source->id,
                    );
                    $i++;
                }
                // Chnage sort
                krsort($entryList);
                // Check entry list and update DB
                foreach ($entryList as $entrySingle) {
                    $feed = Pi::model('feed', $this->getModule())->find($entrySingle['link'], 'link');
                    if (!$feed) {
                        $row = Pi::model('feed', $this->getModule())->createRow();
                        $row->assign($entrySingle);
                        $row->save();
                    }
                }
                // Update source date
                $source->extra = Json::encode($data);
                $source->time_parse_last = time();
                $source->save();
                // set result
                $result['message'] = __('All Feed sources update successfully.');
                $result['status'] = 1;
            }
        }
        return $result;
    }
}