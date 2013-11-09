<?
/*
 * Function Library
 * -------------------------------------------------------------
 * Author:	 Gordon Montgomery
 * Date:	 July 2009
 * File:     xml_functions.php
 * Type:     function library
 * Name:     f_get_xml et al
 * Purpose:  This function library contains a main function f_get_xml(), and a number of helper functions.
 *			 f_get_xml() takes a matrix of data such as that created by class_ps_structure, and returns that data in valid xml tree form
 * 			 root_id:	 Index of the topmost node to start parsing from in the data_index. data outside of this node's scope
 * 			 			 will be ignored.
 * 			 xml_string: The root xml node in string form. Can be any valid xml string, such as <div id="xml"></div>, 
 * 			 			 or <xml_tree xmlns="some_xml_namespace_somewhere"></xml_tree>, etc.
 * 			 data_index: A REFERENCE to a linear matrix containing a node's id, it's parent's id, and it's title, 
 * 			 			 as well as any number of other optional attributes.
 * 			 schema: 	 Used by f_xml_node_builder() to choose the nomenclature of xml nodes. 'xhtml-ul' creates an unordered 
 * 			 			 xhtml list
 * -------------------------------------------------------------
 */
 
/*
This function takes several types of data, parses it into a valid xml tree, and returns the xml data.
*/
function f_get_xml($root_id, $xml_string, &$data_index, $schema) {	
	$_xml = simplexml_load_string($xml_string);
	f_recursive_xml_builder($root_id, $_xml, $data_index, $schema);//pass node pointer etc to the f_recursive1
	return $_xml->asXML();	
}
/*
This function is given a starting node, an array of site hierarchy data and a pointer to an xml node.
It recursively calls itself, constantly updating the xml pointer to where in the xml nodes need to be added.
It does not return anything, but instead the xml pointer it was first called with is modified.
*/
function f_recursive_xml_builder($topnode, $this_node, &$data_index, &$schema) {
	$i = 0; //start at the first node
	foreach ($data_index as $key) { //for each node in the array
		$parent = $data_index[$i]["CO_Parent"]; //get the node's parent
		if ($parent == $topnode) { //if that node is a child of the current topnode
			$id = $data_index[$i]["CO_ID"]; //get the node's id
			$title = $data_index[$i]["CO_seoTitle"]; //get the node's title
			$new_this_node = f_xml_node_builder($id, $title, $this_node, $schema); //get the node builder to build the node and return the pointer
			f_recursive_xml_builder($id, $new_this_node, $data_index, $schema); //pass node pointer etc to the f_recursive1				
		}
		$i++; //go to the next node
	}
}
/*
This function separates out the xml schema that is used to make the xml document.
It is passed the relevant metadata, and the pointer to the right xml node, 
and returns a pointer to the new node it has created
*/
function f_xml_node_builder($id, $title, $this_node, &$schema) {
	$new_this_node = "";
	
	switch ($schema) {
	case "xhtml-ul":
		$url = '?p='.$id;
		
		$new_this_node = $this_node->addChild("ul", "\n"); //get pointer to new node, add child node
		//$title = htmlentities(str_replace("&#039;", "'",$title)); //html_entity_decode()
		
		$title = htmlentities(html_entity_decode($title, ENT_QUOTES));
		 
		if ($id<0){
			$a_pointer = $new_this_node->addChild('li', $title."\n"); //add attribute to node
		} else {
			$a_pointer = $new_this_node->addChild('a', $title."\n"); //add attribute to node
			$a_pointer->addAttribute('href', $url); //add attribute to node
			$a_pointer->addAttribute('style', "display:list-item;"); //add attribute to node
		}
		
		break;
	default:	
		$new_this_node = $this_node->addChild("node", "\n"); //get pointer to new node, add child node
		$new_this_node->addAttribute('id', $id); //add attribute to node
		$new_this_node->addAttribute('title', $title); //add attribute to node
		break;	
	}

	return $new_this_node;
}
/*
This function is given an array of tag types, a list of attributes for each tag, 
and data to be placed in each tag. Note that this does not return a true xml object but creates a 
well formatted string that loosely matches a 1-tier xml list.
*/
function f_html_tag_list_builder($tag_array) {

	$returnval = "";
	foreach($tag_array as $key) {
		$tag = $key[0];
		$body = $key[1];
		$attributes = $tag_array; 
		unset($attributes[0]);
		unset($attributes[0]);
		$attributes = array_values($attributes);
		$returnval .= f_html_tag_builder($tag, $attributes, $body)."\n";
	}
	return $returnval;
}
/*
This function is given a tag type, a list of attributes, and data to be placed in the tag,
and returns a well formatted string that loosely matches xml
*/
function f_html_tag_builder($tag, $attributes, $body) {
	$returnval = '<'.$tag;
	foreach($attributes as $key) {
		$returnval .= " " . $key[0] . '="' . $key[1] . '"';
	}
	$returnval .= '>' . $body . '</'.$tag.'>';
	return $returnval;
}

