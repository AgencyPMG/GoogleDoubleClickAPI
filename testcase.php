<?PHP

//first login
require_once('dfa.php');

$d = new DFACreative();


echo $d->getAuthToken();

try
{
	//print_r($d->uploadCreativeFile(3528475, 6335636, null, file_get_contents("http://tools.pmg.co/robots.txt"), "3528475/1127_Lacoste Report.txt", "text/plain"));
	
	$advertiserId = 3528475;
	$campaignId = 6335636;
	
	//get a list of creatives
	$creatives = $d->getCreatives($advertiserId, $campaignId);
	
	$creative = $creatives->records[0];
	$creativeId = $creative->id;
	
	print_r($creative);
	
	$creativeAsset = $d->saveCreativeAsset($advertiserId, "RobotsFile.txt", file_get_contents("http://tools.pmg.co/robots.txt"));
	
	print_r($creativeAsset);
	
	$creative = json_decode(json_encode($creative), true);
	
	
	
	$creative['creativeAssets'][] = array('assetFilename'=>	$creativeAsset->savedFilename);
	$creative['additionalImageAssets'][] = array('assetFilename'=>	$creativeAsset->savedFilename);
	print_r($creative);
	
	$savedCreative = $d->saveCreative($advertiserId, $campaignId, $creative['id'], $creative['name'], $creative['active'], false, null, $creative['sizeId'], $creative['typeId'], ($creative['version']+1),'FlashInpageCreative', $creative);
	
	print_r($savedCreative);
	
	
	//get a list of creatives
	$creatives = $d->getCreatives($advertiserId, $campaignId);
	
	print_r($creatives);
	
	
}
catch(Exception $e)
{
	echo $e->getMessage();
}



?>