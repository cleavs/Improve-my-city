<?php
/**
 * @version     2.4.1
 * @package     com_improvemycity
 * @copyright   Copyright (C) 2011 - 2012 URENIO Research Unit. All rights reserved.
 * @license     GNU Affero General Public License version 3 or later; see LICENSE.txt
 * @author      URENIO Research Unit
 * 
 * **** WARNING *****
 * MOBILE JSON FUNCTIONALITY (THIS FILE:mobile.json.php) IS CURRENTLY ON ALPHA VERSION 
 * NOT TO BE USED ON PRODUCTION SITES
 *   
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.controller');

class ImprovemycityControllerMobile extends JController
{
	
	/* arguments: 
	 * limit=0 : get ALL issues, limit=5 get recent 5 issues
	 * showComments=1: includes issue's discussion, showComments=0 (default) discussion is not included
	 * */
	public function getIssues()
	{
		//get request
		$showComments = JRequest::getInt('showComments');
		
		//get model and items
		$model = $this->getModel('issues');
		$items	= $model->getItems();
		
		//clean up and prepare for json
		foreach($items as $item){
			unset($item->params);
			if(!$showComments)
				unset($item->discussion);
		}
		//$document = &JFactory::getDocument();
		//$document->setMimeEncoding('text/xml');		
		echo json_encode($items);
		return;
	}	
	
	/* arguments:
	 * issueId=X : get issue with ID = X
	* showComments=1: includes issue's discussion, showComments=0 (default) discussion is not included
	* */	
	public function getIssue()
	{
		//get request
		$showComments = JRequest::getInt('showComments');
		$issueId = JRequest::getInt('issueId');
	
		//get model and items
		$model = $this->getModel('issue');

		$item = $model->getItem($issueId);
		if($item == null){			
			echo json_encode('IssueId: ' .$issueId.' not found');
			return;
		}
		
		//clean up and prepare for json
		unset($item->params);
		if(!$showComments)
			unset($item->discussion);

		echo json_encode($item);
		return;
	}	
	
	
	
	public function getCategories()
	{
	
		return;
	}
	
	public function getTimestamp()
	{
	
		return;
	}	
	
	public function addIssue()
	{
		//get request
		$title = JRequest::getVar('title');
		$catid = JRequest::getVar('catid');
		$address = JRequest::getVar('address');
		$description = JRequest::getVar('description');
		$latitude = JRequest::getVar('latitude');
		$longitude = JRequest::getVar('longitude');
		$userid = JRequest::getVar('userid');
		$token = JRequest::getVar('token'); //security token
		
		//TODO: AUTHENTICATION HERE
		
		//get model
		$model = $this->getModel('addissue');

		$data['title'] = $title;
		$data['catid'] = $catid;
		$data['latitude'] = $latitude;
		$data['longitude'] = $longitude;
		$data['address'] = $address;
		$data['description'] = $description;
		$data['userid'] = $userid;
		
		$s = $model->save($data);
		echo json_encode($s); //0 or 1
		return;
	}

	public function voteIssue()
	{
		$issueId = JRequest::getInt('issueId');
		$userid = JRequest::getVar('userid');
		$token = JRequest::getVar('token'); //security token
			
		return;
	}
	
	public function addComment()
	{
		$issueId = JRequest::getInt('issueId');
		$userid = JRequest::getVar('userid');
		$token = JRequest::getVar('token'); //security token

		return;
	}
}