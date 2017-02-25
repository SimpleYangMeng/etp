<?php
class Common_Type
{
    public static function display($lang = 'zh_CN')
    {
        $display = array(
            'zh_CN' => array(
                '0' => '隐藏',
                '1' => '显示',
            ),
            'en_US' => array(
                '0' => 'Hide',
                '1' => 'Show',
            )
        );
        if ($lang == 'auto') {
            $lang = Ec::getLang();
        }
        return isset($display[$lang]) ? $display[$lang] : $display;
    }

    public static function status($lang = 'zh_CN')
    {
        $status = array(
            'zh_CN' => array(
                '0' => '不可用',
                '1' => '可用',
            ),
            'en_US' => array(
                '0' => 'disabled',
                '1' => 'Enabled',
            )
        );
        if ($lang == 'auto') {
            $lang = Ec::getLang();
        }
        return isset($status[$lang]) ? $status[$lang] : $status;
    }

    public static function activate($lang = 'zh_CN')
    {
        $tmpArr = array(
            'zh_CN' => array(
                '0' => '未激活',
                '1' => '已激活',
                '2' => '停用',
            ),
            'en_US' => array(
                '0' => 'Inactive',
                '1' => 'Activated ',
                '2' => 'disabled',
            )
        );
        if ($lang == 'auto') {
            $lang = Ec::getLang();
        }
        return isset($tmpArr[$lang]) ? $tmpArr[$lang] : $tmpArr;
    }

    public static function receivedType($lang = 'zh_CN')
    {
        $tmpArr = array(
            'zh_CN' => array(
                '1' => '入库单号',
                '2' => '客户参考号',
                '3' => 'SKU',
            ),
            'en_US' => array(
                '1' => 'ASNCode',
                '2' => 'referenceNo',
                '3' => 'SKU',
            )
        );
        if ($lang == 'auto') {
            $lang = Ec::getLang();
        }
        return isset($tmpArr[$lang]) ? $tmpArr[$lang] : $tmpArr;
    }

}