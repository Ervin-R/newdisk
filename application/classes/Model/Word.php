<?php

class Model_Word extends ORM {
    
    /**
     * Auto-update column for creation
     * @var array
     */
    protected $_created_column = [
        'column' => 'created_at',
	'format' => 'Y-m-d H:i:s',
    ];
    
    public function labels() {
        return [
            'name'   => __('Word Name'),
        ];
    }
   
    public function rules() {
        return [
            'name' => [
                ['not_empty'],
                ['max_length', [':value', 32]],
            ],
        ];
    }
    
    
    public function filters() {
        return [
            'name' => [
                ['trim'],
                ['strip_tags'],
            ],
        ];        
    }
    
    /**
     * Returns a list of words using pagination parameters.
     * 
     * @param int $page           Page number
     * @param int $items_per_page Items per page
     * @return array
     */
    public function get_words($page = 1, $items_per_page = 5) {
        
        $page = max($page, 1);
        $items_per_page = max($items_per_page, 1);
        
        $query = ORM::factory('Word')
            ->order_by('id')
            ->offset($page * $items_per_page - $items_per_page)
            ->limit($items_per_page)
            ;
        
        $result = [];
        foreach ($query->find_all() as $word) {
            $result[] = $word->as_array();
        }
        
        return $result;
    }
    
    /**
     * Returns a list of popular words sorted by frequency
     * @return array
     */
    public function get_popular_words() {
        
        return ORM::factory('Word')
               ->select([DB::expr('COUNT(`id`)'), 'word_count'])
               ->order_by('word_count', 'DESC')
               ->limit(20) 
               ->group_by('name') 
               ->find_all() 
               ->as_array('name', 'word_count');
        
    }

}
