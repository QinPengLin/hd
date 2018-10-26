<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 2018/8/31
 * Time: 下午3:33
 */
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_sys_class('model', '', 0);
class member_tg_model extends model {
    public function __construct() {
        $this->db_config = pc_base::load_config('database');
        $this->db_setting = 'default';
        $this->table_name = 'member_tg';
        parent::__construct();
    }
}
?>