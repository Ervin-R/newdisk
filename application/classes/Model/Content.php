<?php

Class Model_Content extends Model {
    
    const cache_var = 'meduza_news';
    const cache_time = 300;
    
    /**
     * Returns a news item from meduza.io for the current user.
     * @return array  News item array
     */
    public function get_news() {
        
        $news = $this->read_news_from_meduza();
        
        if (!$news) {
            return [];
        }
        
        $session_id = Session::instance()->id();
        $news_shown = $this->get_shown_news($session_id);
        
        $items_to_show = [];
        foreach ($news as $id => $item) {
            // Except shown news
            if (in_array($id, $news_shown)) {
                continue;
            }
            $items_to_show[$id] = $item;
        }
        
        if (!$items_to_show) {
            $this->reset_client_news($session_id);
            $items_to_show = $news;
        }
        
        $item_id = array_rand($items_to_show);
        $item = $items_to_show[$item_id];
        $this->add_news_for_client($session_id, $item_id);
        return $item;
    }
    
    /**
     * Reads the Meduza.io news feed.
     * @return array   News item list
     */
    protected function read_news_from_meduza() {
        
        $cache = Cache::instance();
        
        // Get news from cache first
        $items = $cache->get(self::cache_var);
        
        if ($items === NULL) {
            // Get news from Meduza.io
            $items = [];
            foreach (Feed::parse('https://meduza.io/rss/news') as $item) {
                $image = $item['enclosure'];
                $items[sha1($item['guid'])] = [
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'image' => (string) $image->attributes()->url,
                ];
            }
            
            $cache->set(self::cache_var, $items, self::cache_time);
        }
        
        return $items;
    }
    
    /**
     * Returns a list of news items shown for the client specified.
     * @param string $session_id  User session ID
     * @return array              List of news IDs
     */
    protected function get_shown_news($session_id) {
        
        return DB::select()->from('session_news')
               ->where('session_id', '=', $session_id)
               ->execute()
               ->as_array(NULL, 'news_id') 
               ;
    }
    
    /**
     * Saves a news item ID as shown for the client specified. 
     * @param string $session_id   User Session ID
     * @param string $news_id      News item ID (guid)
     */
    protected function add_news_for_client($session_id, $news_id) {
        
        DB::insert('session_news', ['session_id', 'news_id'])
                ->values([$session_id, $news_id])
                ->execute()
                ;
    }
    
    /**
     * Resets news item for the client specified.
     * @param string $session_id   User Session ID
     */
    protected function reset_client_news($session_id) {
        
        DB::delete('session_news')
                ->where('session_id', '=', $session_id)
                ->execute()
                ;
    }
    
    /**
     * Gets a currency value via XML API of the Bank of Russia
     * @param string $code
     * @return string
     */
    public function get_currency_value($code) {
        
        $request = Request::factory('http://www.cbr.ru/scripts/XML_daily.asp?date_req='.date('d/m/Y'));
        
        $request->headers([
            'Content-Type' => 'text/xml',
            'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; rv:47.0) Gecko/20100101 Firefox/73.0',
        ]);

        $request->client()->options([
            // The number of seconds to wait while trying to connect. Use 0 to wait indefinitely
            CURLOPT_CONNECTTIMEOUT => 0,
            // The maximum number of seconds to allow cURL functions to execute
            CURLOPT_TIMEOUT => 10,
        ]);

        $response = $request->execute();        

        if ($response->status() != 200) {
            return 'Invalid HTTP Response';
        }

        $xml = simplexml_load_string($response->body());

        if ($xml === FALSE) {
            return 'XML Parsing Failed';
        }

        $valute = $xml->xpath('Valute[CharCode="'.$code.'"][1]');

        if (!$valute) {
            return 'Invalid currency format';
        }
        
        $valute = $valute[0];

        return 'Official exchange rate of ' . $valute->CharCode . ' is '
            . $valute->Nominal . ' ' . $valute->Name . ' = ' . $valute->Value . ' RUR'
            . ' (set by the Central Bank of Russia on ' . $xml['Date'] . ')';
        
    }
}
