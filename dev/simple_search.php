<?php

function simpleSearch($searchIndex, $keywords) {
	// header("Access-Control-Allow-Origin: *");

    include './dev/credentials.php';
    // Suppress warnings
    error_reporting(0);

    $searchIndex = "Electronics";
    // Region
    $endpoint = "webservices.amazon.in";

    $uri = "/onca/xml";

    $params = array(
        "Service" => "AWSECommerceService",
        "Operation" => "ItemSearch",
        "AWSAccessKeyId" => "AKIAJDFOBDG56PTMTDDQ",
        "AssociateTag" => "rohananand-21",
        "SearchIndex" => $searchIndex,
        "ResponseGroup" => "Images,ItemAttributes,Offers",
        "Sort" => "relevancerank",
        "Keywords" => $keywords
    );

    // Set current timestamp if not set
    if (!isset($params["Timestamp"])) {
        $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
    }

    // Sort the parameters by key
    ksort($params);

    $pairs = array();

    foreach ($params as $key => $value) {
        array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
    }

    // Generate the canonical query
    $canonical_query_string = join("&", $pairs);

    // Generate the string to be signed
    $string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;

    // Generate the signature required by the Product Advertising API
    $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $aws_secret_key, true));

    // Generate the signed URL
    $request_url = 'http://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);

    // echo $request_url;

    $response = file_get_contents($request_url);
    $parsed_xml = simplexml_load_string($response);

    // Verify Request
    foreach($parsed_xml->OperationRequest->Errors->Error as $error){
        echo "Error code: " . $error->Code . "\r\n";
        echo $error->Message . "\r\n";
        echo "\r\n";
    }

       // $result =array(array('price' => 35 ));

       // echo json_encode($result);

    // $result = array($parsed_xml);

    // echo json_encode($result);


 //    $data = array(
	// 	array('id' => '1','first_name' => 'Cynthia'),
	// 	array('id' => '2','first_name' => 'Keith'),
	// 	array('id' => '3','first_name' => 'Robert'),
	// 	array('id' => '4','first_name' => 'Theresa'),
	// 	array('id' => '5','first_name' => 'Margaret')
	// );

 //    echo json_encode($data);

    $data=$parsed_xml->Items;

    foreach($parsed_xml->Items->Item as $current) {
        $html =     '<div class="col-md-4">' .
                        '<div class="card" style="padding:25px;">' .
                            '<div class="img-container">' .
                                '<img src="' . $current->LargeImage->URL . '" width="304" height="236">' .
                            '</div>' .
                            '<div class="card-content">' .
                                '<center><h4 class="product-title-short"><a href="' . $current->DetailPageURL . '">' . $current->ItemAttributes->Title . '</a></h4>' .
                                '<h5>' . 'Lowest Price : <b>' . $current->OfferSummary->LowestNewPrice->FormattedPrice . '</b></h5></center>' .
                            '</div>' .
                            '<div class="card-controls">' .
                                '<form action="./process/compare/compare-load.php" method="POST">' .
                                    '<input type="hidden" name="product_id" value="' . $current->ASIN . '">' .
                                    '<center><a class="btn btn-danger" href=details.php?pid='.$current->ASIN.' name="lookup-button">See Details</a>' .
                                    '</center>'.
                                '</form>' .
                            '</div>' .
                        '</div>' .
                    '</div>';
        echo $html;

    //     $data = array( array('imageURL' => $current->LargeImage->URL,'detailsPage'=> $current->DetailPageURL,'prod_id' => $current->ASIN));
    }
    // echo json_encode($data);
}


?>
