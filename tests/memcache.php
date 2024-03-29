<?php

/**
 * 使用MCache示例
 *
 * 表结构
CREATE TABLE motv_user_info_0 (
  user_id bigint(20) NOT NULL DEFAULT 0 COMMENT 'SPLIT KEY', -- 用户ID
  site_id int NOT NULL DEFAULT 0,                       -- 用来登陆的站点
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 */

require_once "/kpool/kxi/binding/kxi/boot.php";
require_once dirname(__FILE__)."/../src/autoload.php";

$loader = new KAL_ConfigLoader();
// 分表字段
$loader->setSplitMap(array(
    "user" => "user_id",
));
$loader->setDBMan("kxm");
KAL_Factory::init($loader);

$kind = KAL_Factory::getKind("motv_user_info");
$filter = array("KAL_MCacheFilter", array(3600, array(), "kxm"));
$kind->getConfig()->set("filters", array($filter));
$handle = $kind->getHandle();

$user_id = 1610612776;
$row = $handle->findOne($user_id); // 等同于: $handle->findOne(array("user_id" => $user_id));
var_dump($row);
