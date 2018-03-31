<?php
    
// Before using this program, you should create a Google Doc. Then, you need to publish that doc to the web. Use File -> Publish to web (this may be under the "Advanced" File submenu if you're using a different version of Google Docs)

// This is the URL of the editable Google Doc, in case you want to edit it from this page.
    $google_doc_url = "https://docs.google.com/document/d/XXXXXXXXX/edit" ;

// This is the URL of your published Google Doc. (Note, the URLs do not use the same IDs, so you can't easily guess one from the other)
    $published_doc_url = "https://docs.google.com/document/d/e/XXXXXXXXX/pub" ;

// get the contents of the published Google doc
// FIXME -- this should work to create a document object, but it's turning the HTML into a bag of bytes and making special characters into entities, so leave it out for now and use f_g_c instead          
//  $doc = new DOMDocument('1.0', 'UTF-8') ;
//  @$doc->loadHTMLFile($published_doc_url) ;
//  $contents =  $doc->saveHTML() ;
    $contents = file_get_contents($published_doc_url) ;
    
// get the second style element in the Google doc (which has the document styles, not the chrome styles) and put it into a variable so you can reuse it below (it's the one that has the div before it)
    preg_match('/<div id="contents"><style.*?<\/style>/', $contents, $google_styles) ;
// get rid of the div open tag
    $new_head_styles = preg_replace('/<div id="contents">/', "", $google_styles[0]) ;
// clean up the CSS a little to make it a little more readable
    $new_head_styles = preg_replace('/}/', "}\n", $new_head_styles) ;

// This cleans out all the chrome around your content -- I suppose I could have written it as a function with an array, but I thought this would be easier for folks to read (and easier to change if Google changes its document structure. Performance is really the same either way)    
    $contents = preg_replace("/<script.*?<\/script>/s", "", $contents) ;
    $contents = preg_replace("/<div id\=\"header\"(.*?)<\/div>/", "", $contents) ; 
    $contents = preg_replace("/<!DOCTYPE html>/", "", $contents) ;
    $contents = preg_replace("/<html><head>/", "", $contents) ;
    $contents = preg_replace("/<\/head>/", "", $contents) ;
    $contents = preg_replace("/<body>/", "", $contents) ;
    $contents = preg_replace("/<link.*?>/", "", $contents) ;
    $contents = preg_replace("/<style.*?<\/style>/s", "", $contents) ;
    $contents = preg_replace("/<title.*?<\/title>/", "", $contents) ;
	$contents = preg_replace("/<div id\=\"footer.*?<\/div>/", "", $contents) ;
	$contents = preg_replace("/<\/body><\/html>/", "", $contents) ;
?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <title>XXXXX YOUR DOCUMENT TITLE HERE XXXXXX</title>

    <style>
        /* custom page-level styles here, if you want any */
		#google_content {
            
		}  				
  </style>
  
  <!-- these are the styles in the doc that apply specifically to your content -->
  <?php echo $new_head_styles ; ?>
</head>

<body>
    <div id="google_content">
        <?php echo $contents ; ?>	
    </div>
    <div>
        <p>
            <a href="<?php echo $published_doc_url ; ?>">See the raw document.</a>
        </p>
        <p>
            <a href="<?php echo $google_doc_url ; ?>">Edit the content for this page.</a>
        </p>
    </div>
</body>
</html>
