<?php

class PeepSoTainacanAjax extends PeepSoAjaxCallback
{
	public function tainacan(PeepSoAjaxResponse $resp)
	{
		$tainacan = $this->_input->int('tainacan', 'tainacan');

		$resp->success(TRUE);
		$resp->set('tainacan', $tainacan);
	}
}