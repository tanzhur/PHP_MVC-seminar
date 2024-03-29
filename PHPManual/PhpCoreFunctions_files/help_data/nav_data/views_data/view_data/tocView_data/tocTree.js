/*******************************************************************************
 * Copyright (c) 2006, 2007 IBM Corporation and others.
 * All rights reserved. This program and the accompanying materials 
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.eclipse.org/legal/epl-v10.html
 * 
 * Contributors:
 *     IBM Corporation - initial API and implementation
 *******************************************************************************/

// Tree code specific to the help toc

var showExpanders = true;
var ajaxPrefix = "../tocfragment"; 
var pendingSynchTopic = null; // Should the toc be synchronized when the view becomes visible

// The default value of ajaxPrefix works from jsp files but needs to be overridden to 
// a non relative path to work from scripts launched from any page

function setAjaxPrefix(prefix) {
    ajaxPrefix = prefix;
}

/*
 * Returns the currently selected topic's href, or null if no
 * topic is selected.
 */
function getSelectedTopic() {
	var node = getActiveAnchor();
	if (node != null) {
		var href = node.href;
		var index = href.indexOf("/topic/");
		if (index != -1) {
			return href.substring(index + 6);
		}
		index = href.indexOf("/nav/");
		if (index != -1) {
			return "/.." + href.substring(index);
		}
	}
	// no selection
	return null;
}

function isVisible() 
{
    var visibility = parent.parent.getVisibility("toc");
    return visibility == "visible";
}

function selectTopic(topic, isAutosynch)
{
    if (isAutosynch && !isVisible()) {
        pendingSynchTopic = topic;
        return;
    }
    // Is the highlighted node the same as the href? In that case no need to call the server.
    if (oldActive && sameTopic(topic, oldActive.href)) {
           focusOnItem(getTreeItem(oldActive), true);
           return;
    }
    pendingSynchTopic = null;
    var indexAnchor=topic.indexOf('#');
	var parameters;			
	if (indexAnchor!=-1) {
		var anchor=topic.substr(indexAnchor+1);
		topic=topic.substr(0,indexAnchor);
		parameters = "?topic="+topic+"&anchor="+anchor;	
	} else {
		parameters = "?topic="+topic;
	}
	if (isAutosynch) {
	    parameters += "&errorSuppress=true";
	}
	makeShowInTocRequest(parameters);	
    return true;
}

function sameTopic(topicHref, oldActiveHref) {
    if (topicHref == oldActiveHref) {
        return 1;
    }
    // Sometimes the oldActiveHref will start with '../', compare everything from /help on
    if (oldActiveHref.indexOf('../') == 0) {
        var fixedOldActive = oldActiveHref.substring(2);
        var result = topicHref.indexOf(fixedOldActive) >= 0;
        return result;
    }
    return 0;
    
}

function collapseAll() {
    window.location.replace("tocView.jsp?collapse=true");
    return true;
}

function setShowAll(isShowAll, href) {
    var showAllParam = isShowAll ? "on" : "off";
    window.location.replace("tocView.jsp?showAll=" + showAllParam);
}

function setImage(imageNode, image) {
    var imageFile = imagesDirectory + "/" + image + ".gif";
    imageNode.src = imageFile;
    if (image == "plus") {
        imageNode.alt = altPlus;       
    } else if (image == "minus") {
        imageNode.alt = altMinus;     
    } else if (image == "toc_open") {
        imageNode.alt = altBookOpen;    
    } else if (image == "toc_closed") {
        imageNode.alt = altBookClosed;  
    } else if (image == "container_obj") {
        imageNode.alt = altContainer;  
    } else if (image == "container_topic") {
        imageNode.alt = altContainerTopic;  
    } else if (image == "topic") {
        imageNode.alt = altTopic;
    } else {
        imageNode.alt = "";
    }
}

function updateImage(imageNode, isExpanded) {
    var src = imageNode.src;
    if (isExpanded) {   
        if (src.match( /toc_closed.gif$/)) {
            setImage(imageNode, "toc_open");
        }
    } else {
        if (src.match( /toc_open.gif$/)) {           
            setImage(imageNode, "toc_closed");
        }
    }
}

function loadChildren(treeItem) { 
    var parameters = "";
    if (treeItem !== null  && treeItem.nodeid !== null) {
        setLoadingMessage(treeItem, loadingMessage);
        var topAncestor = getTopAncestor(treeItem);
        parameters += "?toc=";
        parameters += topAncestor.nodeid;
        if (topAncestor !== treeItem) {
            parameters += "&path=";
            parameters += treeItem.nodeid;
        }
    }
    makeNodeRequest(parameters);
}

function updateTocTree(xml) {
    updateTree(xml);
}

function makeNodeRequest(parameters) {
    var href;
    if (ajaxPrefix) {
        href = ajaxPrefix + "/tocfragment" +parameters; 
    } else {
        href = "../tocfragment" + parameters;
    }
    var callback = function(xml) { updateTocTree(xml);}; 
    var errorCallback = function() { 
        // alert("ajax error"); 
    };
    ajaxRequest(href, callback, errorCallback);
}

function makeShowInTocRequest(parameters) {
    var href;
    if (ajaxPrefix) {
        href = ajaxPrefix + "/tocfragment" +parameters; 
    } else {
        href = "../tocfragment" + parameters;
    }
    var callback = function(xml) { showInToc(xml);}; 
    var errorCallback = function() { 
        // alert("ajax error"); 
    };
    ajaxRequest(href, callback, errorCallback);
}

function showInToc(xml) { 
    var tocData = xml.documentElement;  
    if (tocData.tagName != "tree_data") {
        return;
    }  
    if (showErrors(xml)) {
        return;
    }
    
    var errorTags = xml.getElementsByTagName ("error");   
    var treeRoot = document.getElementById("tree_root");
    var nodes = tocData.childNodes;
    for (var i = 0; i < nodes.length; i++) {
        var node = nodes[i];
        if (node.tagName == "numeric_path") {
            var selectedChild = findChild(treeRoot, "DIV");
            var path = node.getAttribute("path");
            var isShowing = openPath(selectedChild, path);
            if (!isShowing) {
                makeNodeRequest("?expandPath=" + path + "&errorSuppress=true");
            }
            return;
         }  
     }
}

function openPath(containerNode, path) {
     if (!containerNode) {
         return false;
     }
     var index = path.indexOf("_");
     var segment;
     if (index == -1) { 
         segment = path;
     } else {
         segment = path.substr(0, index);
     }
     for (var i = 0; i < segment; i++) {
         containerNode = containerNode.nextSibling;
         if (!containerNode) {
             return false;
         }
     }
     if (index == -1) {
         focusOnItem(containerNode, true);
         return true;
     } else {
         return openPath(findChild(findChild(containerNode, "DIV"), "DIV"), path.substr(index + 1));
     }
 }


function isAutosynchEnabled() {
	var value = getCookie("synchToc");
	return value ? value == "true" : false;
}

function setAutosynchEnabled(value) {
	setCookie("synchToc", value);
	var newValue = isAutosynchEnabled();
	parent.tocToolbarFrame.setButtonState("synchnav", newValue);
	if (value != newValue) {
	    alert(cookiesRequired);
	}  
}

function toggleAutosynch() {
    setAutosynchEnabled(!isAutosynchEnabled());  
}

function onShow() { 
    if ( isAutosynchEnabled() && pendingSynchTopic !== null ) {
        selectTopic(pendingSynchTopic, true);
    } 
}

if (isInternetExplorer){
   document.onclick = treeMouseClickHandler;
   document.ondblclick = treeMouseDblClickHandler;
   document.onkeydown = treeKeyDownHandler;
   document.onmouseup = rightClickHandler;		// Defect 762
} else {
   document.addEventListener('click', treeMouseClickHandler, true);
   document.addEventListener('dblclick', treeMouseDblClickHandler, true); 
   //document.ondblclick = treeMouseDblClickHandler;
   document.addEventListener('keydown', treeKeyDownHandler, true);
   document.addEventListener('mouseup', rightClickHandler, true);		// Defect 762
}
