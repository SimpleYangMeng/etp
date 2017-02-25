<?php
/* @desc: 服务中心控制器
 *
 */
class Default_HelpController extends Ec_Controller_DefaultAction
{

	public function preDispatch()
    {
        $language = Ec_Lang::getInstance()->getCurrentLanguage();
        $this->language = empty($language) ? 'zh_CN' : $language;
        $this->tplDirectory	= "default/views/service-center/";
    }

    /* @desc:常见问题
     *
     */
    public function questionAction() {
        $this->view->languageTpl = $this->language;
        echo Ec::renderTpl($this->tplDirectory . "question.tpl", 'layout-etp');
    }

    /* @desc:关于我们
     *
     */
    public function aboutUsAction() {
        $this->view->languageTpl = $this->language;
        echo Ec::renderTpl($this->tplDirectory . "about.tpl", 'layout-etp');
    }

    /* @desc:忘记密码
     *
     */
    public function forgotPasswordAction() {

    }

    /* @desc: 合作银行
     *
     */
    public function cooperativeBankAction() {
        $this->view->languageTpl = $this->language;
        echo Ec::renderTpl($this->tplDirectory . "cooperative-bank.tpl", 'layout-etp');
    }

    /**
     * [helpAction description]
     * @return [type] [description]
     */
    public function guideAction() {
        $this->view->languageTpl = $this->language;
        $visitor_type = $this->getRequest()->getParam('visitor_type', 1);
        $this->view->visitor_type = $visitor_type;
        $this->view->content = $visitor_type == 1 ? '买家指南' : '卖家指南';
        echo Ec::renderTpl($this->tplDirectory . "guide.tpl", 'layout-etp');
    }
}