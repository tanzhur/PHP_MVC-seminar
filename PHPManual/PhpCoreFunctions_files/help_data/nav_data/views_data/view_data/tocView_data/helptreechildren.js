/*******************************************************************************
 * Copyright (c) 2006, 2007 IBM Corporation and others.
 * All rights reserved. This program and the accompanying materials 
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.eclipse.org/legal/epl-v10.html
 * 
 * Contributors:
 *     IBM Corporation - initial API and implementation
 * 	   2008/11/04 - updated by Xu Yumei(IBM Corp.) for quick search for anchor
 *******************************************************************************/

// Functions to update the nodes of a dynamic tree based
// on an XML dom. 

var selectedNode;
var highlightSelectedNode;

function updateTree(xml) { 
    var tocData = xml.documentElement;  
    if (tocData.tagName != "tree_data") {
        return;
    }      
    showErrors(xml);    
    var treeRoot = document.getElementById("tree_root");
    var nodes = tocData.childNodes;
    selectedNode = null;
    mergeChildren(treeRoot, nodes);
    if (selectedNode != null) {
        // Focusing on the last child will increase the chance that it is visible
        if (!highlightSelectedNode) {
            focusOnDeepestVisibleChild(selectedNode, false);
        }
        focusOnItem(selectedNode, highlightSelectedNode);
    }
 }
 
 function showErrors(xml) {
    var errorTags = xml.getElementsByTagName ("error");
    
    for (var i = 0; i < errorTags.length; i++) {
         var nextError = errorTags[i];
         var errorChildren = nextError.childNodes;
         // Is the next node a text node
         if (errorChildren.length > 0 && errorChildren[0].nodeType == 3) { 
             var message = errorChildren[0].data;
             alert(message);
         }
    }
    return errorTags.length > 0;
 }
 
function mergeChildren(treeItem, nodes) {
    var childContainer;
    if (treeItem.id == "tree_root") {
        childContainer=treeItem;
    } else {
        childContainer = findChild(treeItem, "DIV");
    }
    var childAdded = false;
    var hasPlaceholder = childContainer != null && childContainer.className == "unopened";
    if (nodes) {  
        for (var i = 0; i < nodes.length; i++) {
            var node = nodes[i];
            if (node.tagName == "node") {
                if (hasPlaceholder) {
                    // Remove the loading message
                    treeItem.removeChild(childContainer);
                    hasPlaceholder = false;
                    childContainer = null;
                }
                if (childContainer === null) {
                    childContainer = document.createElement("DIV");
                    childContainer.className = "group";              
                    setAccessibilityRole(childContainer, WAI_GROUP);
                    treeItem.appendChild(childContainer);
                }
                var title = node.getAttribute("title");
                var isLeaf = node.getAttribute("is_leaf");
                var href = node.getAttribute("href");
                var image = node.getAttribute("image");
                var id = node.getAttribute("id");
                
                var tocID = node.getAttribute("tocID");
                var topicID = node.getAttribute("topicID");
                if(tocID != null) {
                	id = id+"tocID="+tocID;
                }
                else {
                	id = id+"topicID="+topicID;
                }
                
                var childItem = mergeChild(childContainer, id, title, href, image, isLeaf);
                var isSelected = node.getAttribute("is_selected");
                if (!isLeaf) {
                    mergeChildren(childItem, node.childNodes);
                }
                if (isSelected) {
                    selectedNode = childItem;
                    highlightSelectedNode = node.getAttribute("is_highlighted");
                }
                childAdded = true;
            } 
        }   
     }

     if (childAdded) {
         // Expand this node if it was collapsed and has children in the xml tree        
        var childClass = getChildClass(treeItem);
        if (childClass == "hidden") {
            toggleExpandState(treeItem);
        } else {
            changeExpanderImage(treeItem, true); 
            setWAIExpansionState(treeItem, true);
        }
     }  
}

// Create a child if one with this if does not exist  
function mergeChild(treeItem, id, name, href, image, isLeaf) {  
	var tocIndex = id.indexOf("tocID=");
	var topicIndex = id.indexOf("topicID=");
	var tocID;
	var topicID;
	if(tocIndex!=-1) {// it's a root
		tocID = id.substring(tocIndex+6);
		id = id.substring(0,tocIndex);
	}
	else if(topicIndex !=-1) {// it's a child
		topicID = id.substring(topicIndex+8);
		id = id.substring(0,topicIndex);
	}

    var children = treeItem.childNodes;
    if (children !== null) {
        for (var i = 0; i < children.length; i++) {
            if (children[i].nodeid == id ) {
                return children[i];
            }
        }
    }
        
    var childItem = document.createElement("DIV");
    // roots should have a className of "root" to prevent indentation
    if (treeItem.id == "tree_root") {
        childItem.className = "root";
    } else {
        childItem.className = "visible"; 
    }
    childItem.nodeid = id;
    treeItem.appendChild(childItem);
    
    // Create a span to prevent line breaking
    var container = document.createElement("SPAN");
    container.className = "item";
    childItem.appendChild(container);
   
    var topicImage;
    if (image) {
        topicImage = document.createElement("IMG");
        setImage(topicImage, image);
    }  
    
    var topicName=document.createTextNode(name);
    
    if (showExpanders) {
        var plusMinusImage= document.createElement("IMG");
        plusMinusImage.className = "expander";
        setImage(plusMinusImage, "plus");
        if (isLeaf) {
            plusMinusImage.className = "h";
            plusMinusImage.alt = "";
        }
        container.appendChild(plusMinusImage);
    }
      
    var anchor = document.createElement("a");
    if (href === null) {
        // anchor.href = "about:blank";
        anchor.className = "nolink";
    } else {
        anchor.href = href;
    }
    anchor.title = name;
    if(id.indexOf(".xml")!=-1){
    	anchor.id = id;
    	anchor.name = tocID;
    }
    else 
    	anchor.id = topicID;
    setAccessibilityRole(anchor, WAI_TREEITEM);
    
    if (topicImage) {
        anchor.appendChild(topicImage);
    }
    anchor.appendChild(topicName);
    container.appendChild(anchor);
    
    if (!isLeaf) {
        var innerDiv = document.createElement("DIV");  
        innerDiv.className = "unopened";
        setWAIExpansionState(anchor, false);
        childItem.appendChild(innerDiv);
    }
    return childItem;
}

function setLoadingMessage(treeItem, message) {   
    var placeholderDiv = findChild(treeItem, "DIV");
    if (placeholderDiv !== null && placeholderDiv.childNodes.length == 0) {      
        var msg = document.createTextNode(message);
        placeholderDiv.appendChild(msg);
    }
}
