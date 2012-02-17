<?PHP


class DFACreative extends DFA
{

	/**
	see: http://code.google.com/apis/dfa/docs/reference/v1.16/creative/service.html#assignCreativeGroupsToCreative
	@param campaignId float The campaignId
	@param creativeId float The creativeid
	@param creativeGroupIds array Array of GreativeGroupIds
	*/
	public function assignCreativeGroupsToCreative($campaignId, $creativeId, $craetiveGroupIds=array())
	{
		$soapClient = $this->getNewSOAPClient('creative');
		return $soapClient->assignCreativeGroupsToCreative($campaignId, $creativeId, $creativeGroupIds);
		
	}


	public function generateCreativeUploadSession($advertiserId, $campaignId)
	{
		$creativeSessionRequest = array('advertiserId'=>$advertiserId, 'campaignId'=>$campaignId);
		$soapClient = $this->getNewSOAPClient('creative');

		return $soapClient->generateCreativeUploadSession($creativeSessionRequest);		
	}

	public function uploadCreativeFile($advertiserId, $campaignId, $creativeUploadId, $fileData, $fileName, $mimeType)
	{
		if($creativeUploadId == null)
		{
			$session = $this->generateCreativeUploadSession($advertiserId, $campaignId);
			$creativeUploadId = $session->creativeUploadId;
		}
		$creativeUploadSummary = array('advertiserId'=>$advertiserId, 'campaignId'=>$campaignId, 'creativeUploadId'=>$creativeUploadId);
		$rawFiles = array(array('fileData'=>$fileData, 'filename'=>$fileName, 'mimeType'=>$mimeType));
		$uploadRequest = array('creativeUploadSessionSummary'=>$creativeUploadSummary, 'rawFiles'=>$rawFiles);
		
		$soapClient = $this->getNewSOAPClient('creative');
		return $soapClient->uploadCreativeFiles($uploadRequest);
		
	}
	
	public function replaceRichMediaAsset($creativeId, $oldAssetFileName, $newAssetFileName, $fileData, $parentAssetId=null)
	{
		$assetRequest = array("assetFileName"=>$newAssetFileName, "creativeId"=>$creativeId, "fileData"=>$fileData, "parentAssetId"=>$parentAssetId);
		$soapClient = $this->getNewSOAPClient('creative');
		return $soapClient->replaceRichMediaAsset($oldAssetFileName, $assetRequest);
	}
	
	public function uploadRichMediaAsset($creativeId, $assetFileName, $fileData, $parentAssetId=null)
	{
		$assetRequest = array("assetFileName"=>$assetFileName, "creativeId"=>$creativeId, "fileData"=>$fileData, "parentAssetId"=>$parentAssetId);
		$soapClient = $this->getNewSOAPClient('creative');
		return $soapClient->uploadRichMediaAsset($assetRequest);

	}
	
	public function deleteRichMediaAsset($creativeId, $assetFileName)
	{
		$soapClient = $this->getNewSOAPClient('creative');
		return $soapClient->deleteRichMediaAsset($creativeId,$assetFileName);

	}
	
	
	public function getCreatives($advertiserId, $campaignId=null, $searchString="*", $isActive=null, $pageNumber=1, $pageSize=25, $studioCreative=null)
	{
		$creativeSearchCriteria = array("advertiserId"=>$advertiserId, "campaignId"=>$campaignId, "activeStatus"=>$isActive, "searchString"=>$searchString, "pageNumber"=>$pageNumber, "pageSize"=>$pageSize, "studioCreative"=>$studioCreative, "archiveStatusFilter"=>null);
		
		$soapClient = $this->getNewSOAPClient('creative');
		return $soapClient->getCreatives($creativeSearchCriteria);

	}
	
	public function saveCreativeAsset($advertiserId, $name, $content, $forHTMLCreatives=true)
	{
		$creativeAsset = array("advertiserId"=>$advertiserId, "name"=>$name, "content"=>$content, "forHTMLCreatives"=>$forHTMLCreatives);
		
		$soapClient = $this->getNewSOAPClient('creative');
		return $soapClient->saveCreativeAsset($creativeAsset);
	}
	
	public function deleteCreative($creativeid)
	{
		$soapClient = $this->getNewSOAPClient('creative');
		return $soapClient->deleteCreative($creativeid);

	}
		
	public function saveCreative($advertiserId, $campaignId=0, $creativeId=0, $creativeName, $active=true, $archived=false, $creativeFieldAssignments=array(), $sizeId=0, $typeId=1, $version=1, $subclass='', $subclassParams=array())
	{
		
		$creative = array(
		    'id' => $creativeId,
		    'name' => $creativeName,
		    'advertiserId' => $advertiserId,
		    'sizeId' => $sizeId,
		    'typeId' => $typeId, 
		    'active' => $active,
		    'archived' => $archived,
		    "creativeFieldAssignments"=>$creativeFieldAssignments,
		    'version' => $version);
		 
		if($subclass != '')
		{ 
			$creative = array_merge($creative, $subclassParams);
			$creative = new SoapVar($creative, SOAP_ENC_OBJECT, 'ImageCreative', $this->namespace);
		}

		$soapClient = $this->getNewSOAPClient('creative');
		return $soapClient->saveCreative($creative, $campaignId);
	}
	
	public function saveCreativeObject($creativeObject, $campaignId=0, $creativeObjectType)
	{
	
		$creative = new SoapVar($creativeObject, SOAP_ENC_OBJECT, $creativeObjectType, $this->namespace);
	
		$soapClient = $this->getNewSOAPClient('creative');
		return $soapClient->saveCreative($creativeObject, $campaignId);
	}

}



?>