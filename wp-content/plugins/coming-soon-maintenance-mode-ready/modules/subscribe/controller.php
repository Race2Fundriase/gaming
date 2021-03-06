<?php
class subscribeControllerCsp extends controllerCsp {
	public function create() {
		$res = new responseCsp();
		$data = reqCsp::get('post');
		if(isset($data['withoutConfirm']))
			$data['withoutConfirm'] = false;
		 if($this->getModel()->create($data)) {
			 $res->addMessage(langCsp::_(frameCsp::_()->getModule('options')->get('sub_success_msg')));
		 } else
			 $res->pushError ($this->getModel()->getErrors());
		 return $res->ajaxExec();
	}
	public function confirm() {
		$res = new responseCsp();
		if($this->getModel()->confirm(reqCsp::get('get'))) {
			$res->addMessage(langCsp::_('Your subscription was activated!'));
		} else
			$res->pushError ($this->getModel()->getErrors());
		return $res;
	}
	public function getList() {
		$res = new responseCsp();
		if($count = $this->getModel()->getCount()) {
			$list = $this->getModel()->getList(reqCsp::get('post'));
			$res->addData('list', $list);
			$res->addData('count', $count);
			$res->addMessage(langCsp::_('Done'));
		} else
			$res->pushError ($this->getModel()->getErrors());
		return $res->ajaxExec();
	}
	public function changeStatus() {
		$res = new responseCsp();
		if($this->getModel()->changeStatus(reqCsp::get('post'))) {
			$res->addMessage(langCsp::_('Done'));
		} else
			$res->pushError ($this->getModel()->getErrors());
		return $res->ajaxExec();
	}
	public function remove() {
		$res = new responseCsp();
		if($this->getModel()->remove(reqCsp::get('post'))) {
			$res->addMessage(langCsp::_('Done'));
		} else
			$res->pushError ($this->getModel()->getErrors());
		return $res->ajaxExec();
	}
	public function getPermissions() {
		return array(
			CSP_USERLEVELS => array(
				CSP_ADMIN => array('getList', 'changeStatus', 'remove')
			),
		);
	}
}

