<?php

    $html = "";

    include './cors.php';
    include './credentials.php';

    $sql = "SELECT * from bargainbin";
    // error_reporting(0);

    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

            // The region you are interested in
            $endpoint = "webservices.amazon.in";

            $uri = "/onca/xml";

            $pid = $row["pid"];

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
            $current = $parsed_xml->Items->Item;

            response[] = array("pid" => $pid, "img" => $current->SmallImage->URL, "title" => $current->ItemAttributes->Title,
                                "discount" => row["discount"], "vemail"  => row["vemail"]);

        }

        echo json_encode(response);
    }

?>
