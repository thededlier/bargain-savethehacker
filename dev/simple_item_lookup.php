<?php

function simpleItemLookup($pid) {
    include './dev/credentials.php';
    include './dev/cors.php';
    // Suppress warnings
    error_reporting(0);
    // session_start();

    $email = $_SESSION["useremail"];
    // The region you are interested in
    $endpoint = "webservices.amazon.in";

    $uri = "/onca/xml";

    $params = array(
        "Service" => "AWSECommerceService",
        "Operation" => "ItemLookup",
        "AWSAccessKeyId" => "AKIAJDFOBDG56PTMTDDQ",
        "AssociateTag" => "rohananand-21",
        "ItemId" => $pid,
        "IdType" => "ASIN",
        "ResponseGroup" => "Images,ItemAttributes,Offers"
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

    $response = file_get_contents($request_url);
    $parsed_xml = simplexml_load_string($response);

    // Verify Request
    foreach($parsed_xml->OperationRequest->Errors->Error as $error){
        echo "Error code: " . $error->Code . "\r\n";
        echo $error->Message . "\r\n";
        echo "\r\n";
    }

    // echo $parsed_xml->OperationRequest->RequestId;

    $html = "";
    $attr = "";

    $current = $parsed_xml->Items->Item;

    foreach($current->ItemAttributes->Feature as $itemFeature) {
        $attr .= '<li class="list-group-item">' . $itemFeature . '</li>';
    }

    $sql  = "SELECT * FROM bargainbin where pid = '$pid' and vemail = '$email'";
    $result = $conn->query($sql);

    $discount = 0;

    if($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $discount = $row["discount"];
    }
    $html =     '<div class="card col-md-11">' .
                    '<div class ="card">'.
                    '<div class="col-md-6 img-containter-big">' .
                        '<img src="' . $current->LargeImage->URL . '" class="img-responsive">' .
                    '</div>' .
                    '</div>' .
                    '<div class="col-md-6">' .
                        '<input type="hidden" name="product_id" value="' . $current->ASIN . '">' .
                        '<h4><a href="' . $current->DetailPageURL . '">' . $current->ItemAttributes->Title . '</a></h4>' .
                        '<h5>' . 'Lowest Price : <b>' . $current->OfferSummary->LowestNewPrice->FormattedPrice . '</b></h5>' .
                        '<h5>' . 'Your Price : <b> INR ' . $current->OfferSummary->LowestNewPrice->Amount * (100-$discount)/10000 . '</b></h5>' .
                        '<ul class="list-group">' .
                            $attr .
                        '</ul>' .
                    '</div>' .
                '</div>' ;

    return $html;
}
?>
