
<?php
$mainurl = 'https://www.treebo.com';
$url = 'https://www.treebo.com/cities';	

	$html = file_get_contents($url);					 
	$treebo = new DOMDocument();
	libxml_use_internal_errors(TRUE); //disable libxml errors
		if (!empty($html))
			{ 
				$treebo->loadHTML($html);
				libxml_clear_errors(); //remove errors for html
				$treebo_xpath = new DOMXPath($treebo);			
				$tb = $treebo_xpath->query('//li[@class="text-1 cities-page__list-item"]/a');
				foreach ($tb as $key )
				{
					$newurl = $mainurl.$key->getAttribute('href');
					//echo "<br>";
					$newhtml = file_get_contents($newurl);
					//echo die;
					$treebo1 = new DOMDocument();
					libxml_use_internal_errors(TRUE); //disable libxml errors
					if (!empty($newhtml))
					{
						$treebo1->loadHTML($newhtml);
						libxml_clear_errors();//remove errors for html
						$treebo1_xpath = new DOMXPath($treebo1);
						$tb1 = $treebo1_xpath->query('//h2[@class="r-hotel__name heading-1"]/a');
						foreach ($tb1 as $key1)
						{
							$newurl1 = $mainurl.$key1->getAttribute('href');
							//echo "<br>";
							$newhtml1 = file_get_contents($newurl1);
							//echo die;
							$treebo2 = new DOMDocument();
							libxml_use_internal_errors(TRUE);//disable libxml errors
							if(!empty($newhtml1))
							{
								$treebo2->loadHTML($newhtml1);
								libxml_clear_errors();//remove errors for html
								$treebo2_xpath = new DOMXPath($treebo2);
								$tb2 = $treebo2_xpath->query('//h2[@class="text-1 hd-details__nav-container__address"]');
								$tb3 = $treebo2_xpath->query('//h1[@class="heading-1 hd-hotel__title"]');
								$tb4 = $treebo2_xpath->query('//a[@class="hd-hotel__map-thumbail"]');
								foreach ($tb4 as $key4)
								{
									$latlng = $key4->getAttribute('href');
									//echo die;
									$latlng1 = str_replace("https://www.google.com/maps/place/","",$latlng);
									//echo die;
									$latlng2 = explode(",", $latlng1);
									$latitude = $latlng2[0];
									//echo die;
									$longitude = $latlng2[1];
									//echo die;
								}
								foreach ($tb3 as $key3)
								{
									$hotelname = $key3->nodeValue;
									//echo die;
								}
								foreach ($tb2 as $key2)
								{
									$address = $key2->nodeValue;
									//echo die;
								}
								
							 	$sqlData  = "('".$hotelname."','".$address."','".$latitude."','".$longitude."')";
							 	//echo die;
							 	 $sql = "INSERT INTO details (`hotelname`,`address`,`latitude`,`longitude`) VALUES".$sqlData;
	
   									if ($conn->query($sql) === TRUE)
   								 	{
    									echo "New record created successfully";
       								} 
       								else 
       								{
    									echo "Error: " . $sql . "<br>" . $conn->error;
          							}	


							}
						}
					}
				}
			}
?>