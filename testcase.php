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

	print_r($creatives);
	
	$creative = $creatives->records[0];
	$creativeId = $creative->id;
	
	$creativeAsset = $d->saveCreativeAsset($advertiserId, "1127_Lacoste Report.txt", file_get_contents("http://tools.pmg.co/robots.txt"));
	
	print_r($creativeAsset);
	
	$savedCreative = $d->saveCreative($advertiserId, $campaignId, $creative->id, $creative->name, $creative->active, false, null, $creative->sizeId, $creative->typeId, ($creative->version+1),'ImageCreative', array("assetFilename"=>$creativeAsset->savedFilename));
	
		
	print_r($savedCreative);
	//print_r($d->deleteCreative($creativeId));

	
}
catch(Exception $e)
{
	echo $e->getMessage();
}



?>