<?php
/**
 * Pi Engine (http://pialog.org)
 *
 * @link            http://code.pialog.org for the Pi Engine source repository
 * @copyright       Copyright (c) Pi Engine http://pialog.org
 * @license         http://pialog.org/license.txt New BSD License
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
            'message' => 'Feed update',
            'status' => 1,
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
                // Read feed list
                try {
                    $rss = ZendReader::import($source->link);
                } catch (ZendRuntimeException $e) {
                    // feed import failed
                    $result['message'] = sprintf('Exception caught importing feed: %s', $e->getMessage());
                    $result['status'] = 0;
                    return $result;
                    exit;
                }
                // Get feed date
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
                    'dateModified' => Json::encode($rss->getDateModified()),
                    'image' => Json::encode($rss->getImage()),
                );
                // Set feed entry date
                foreach ($rss as $entry) {
                    $feed = Pi::api('feed', 'reader')->getFeed($entry->getLink(), 'link');
                    if (empty($feed)) {
                        $row = Pi::model('feed', $this->getModule())->createRow();
                        $row->title = _escape($entry->getTitle());
                        $row->link = _escape($entry->getLink());
                        $row->description = _escape($entry->getDescription());
                        $row->date_modified = Json::encode($entry->getDateModified());
                        $row->status = 1;
                        $row->time_create = time();
                        $row->source = $source->id;
                        $row->save();
                    }
                }
                // Update source date
                $source->extra = Json::encode($data);
                $source->time_parse_last = time();
                $source->save();
            }
        }
        return $result;
    }
}