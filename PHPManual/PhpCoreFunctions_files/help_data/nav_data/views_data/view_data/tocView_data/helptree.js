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

// Code to handle the expansion, contraction and navigation
// of nodes in a tree.

var oldActive;
var oldActiveClass;

// WAI Roles
var WAI_TREEITEM = "wairole:treeitem";
var WAI_TREE = "wairole:tree";
var WAI_GROUP = "wairole:group";
var WAI_APPLICATION = "wairole:application";

/**
 * Returns the currently selected (highlighted) tree node anchor.
 */
function getActiveAnchor() {
	return oldActive;
}

/**
 * handler for expanding / collapsing topic tree
 */
function treeMouseClickHandler(e) {
  	var clickedNode = getEventTarget(e);
	if (!clickedNode) { return; }
	
	// Is it an expander node?
	
	if (clickedNode.className == "expander") {
	    toggleExpandState(clickedNode);
	    cancelEventBubble(e);
	} else if ( clickedNode.tagName == 'A' || clickedNode.tagName == 'IMG') {
	    var treeItem = getTreeItem(clickedNode);
	    if (treeItem !== null) {
	        highlightItem(getTreeItem(clickedNode), true); 
	    } 
	} 	
}


/**
 * handler for double click
 */
function treeMouseDblClickHandler(e) {
  	var clickedNode = getEventTarget(e);
	
	if (clickedNode.className == "expander" || clickedNode.tagName == 'A' || clickedNode.tagName == 'IMG') {
	    toggleExpandState(clickedNode);
	    cancelEventBubble(e);
	} 	
}

/**
 * handler for right click
 * @author huqiongk
 */
function rightClickHandler(e) {					// Defect 762
	var theEvent = window.event||e; 
	cancelEventBubble(theEvent);
		
	if (theEvent.button != 2) {			// Defect 885
		return true;
	}
	
	var clickedNode = getEventTarget(theEvent);
	if (!clickedNode) { return; }
	
	var treeItem = getTreeItem(clickedNode);
	
  	var childClass = getChildClass(treeItem); 
	if (childClass == "visible") {
		goLeft(treeItem);
	}
	if (childClass == "hidden" || childClass == "unopened") {
		goRight(treeItem);
	}  	 
	return false;
}

/**
 * Handler for key down (arrows)
 */
function treeKeyDownHandler(e)
{
	var key = getKeycode(e);
	
	// Always cancel the event bubble for navigation keys
  	cancelEventBubble(e);
	var clickedNode = getEventTarget(e);
	var treeItem = getTreeItem(clickedNode);
	
  	if (key == 79) {	  							// Defect 762
		var childClass = getChildClass(treeItem); 		
		if (childClass == "hidden" || childClass == "unopened") {
		    goRight(treeItem);
		    return false;
		}  	 
		return true; 	
  	}
  	if (key == 66) {	
  		var childClass = getChildClass(treeItem); 
  		if (childClass == "visible") {
			goLeft(treeItem);
			return false;
		}
		return true;
  	}
  		
	if ( key <35 || key > 40) {
		return true;
	}	
	
  	if (key == 35) { // End - go to last visible child
  	    goToEnd();
  	} else if (key == 36) { // Home - go to first element
  	    goHome();
  	}
		
	var clickedNode = getEventTarget(e);
	var treeItem = getTreeItem(clickedNode);	
  	
    if (!treeItem && key >= 37) { return true; }
    
  	if (key == 37) { // Left arrow, collapse
  	    goLeft(treeItem);
  	} else if (key == 38 ) { // Up arrow, go up
  	    goUp(treeItem);
  	} if (key == 39) { // Right arrow, expand
  	    goRight(treeItem);
  	} else if (key == 40 ) { // Down arrow, go down
  		goDown(treeItem);
  	}
  		
  	return false;
}

// Handle a HOME key event
function goHome() {   
    var treeRoot = document.getElementById("tree_root");
    if (treeRoot === null) { 
        return; 
    }
    focusOnItem(findChild(treeRoot, "DIV"), false);
}

function goToEnd() {    
    var treeRoot = document.getElementById("tree_root");
    if (treeRoot === null) { 
        return; 
    }

    focusOnDeepestVisibleChild(treeRoot.parentNode, false);
}

// Handle a left arrow key event
function goLeft(treeItem) {  
    var childClass = getChildClass(treeItem); 
    if (childClass == "visible" && showExpanders) {
        toggleExpandState(treeItem);
     } else {
         focusOnItem(getTreeItem(treeItem.parentNode), false);
     }
}

function goRight(treeItem) {     
    var childClass = getChildClass(treeItem);
    if (childClass == "hidden" || childClass == "unopened") {
        toggleExpandState(treeItem);
        return;
     }       
     focusOnItem(findChild(findChild(treeItem, "DIV"), "DIV"), false);
}

function goUp(treeItem) {
   // If there is a previous sibling, visit it's last child
   // otherwise focus on the parent
  
   for (var prev = treeItem.previousSibling; prev !== null; prev = prev.previousSibling) {
        if (prev.tagName == "DIV") {
            focusOnDeepestVisibleChild(prev, false);
            return;
        }
    } 
    focusOnItem(getTreeItem(treeItem.parentNode), false);
}

function goDown(treeItem) {
    // If the node is expanded visit the first child       
    var childClass = getChildClass(treeItem);
    if (childClass == "visible") {
        focusOnItem(findChild(findChild(treeItem, "DIV"), "DIV"), false);
        return;
    }
    // visit the next sibling at this level, if not found try higher levels
    for (var level = treeItem; level !== null; level = getTreeItem(level.parentNode)) {
        for (var next = level.nextSibling; next !== null; next = next.nextSibling) {
            if (next.tagName == "DIV") {
                focusOnItem(next, false);
                return;
            }
        }
    }   
}

function focusOnDeepestVisibleChild(treeItem, isHighlighted) { 
    var group = findChild(treeItem, "DIV");
    if (group) {
        var childDiv = findLastChild(group, "DIV");
        if (childDiv) {  
            if (childDiv.className == "visible" || childDiv.className == "root" ) {        
                focusOnDeepestVisibleChild(childDiv, isHighlighted);
                return;
            }
        }
    }
    focusOnItem(treeItem, isHighlighted);
}

function findAnchor(treeItem) {
    if (treeItem === null) { 
        return null; 
    }
    // Items with children will use a span to contain the anchor
    var anchorContainer = findChild(treeItem, "SPAN");
    if (!anchorContainer) { 
        return treeItem; 
    }
    return findChild(anchorContainer, "A");
}

// Focus on the anchor within a tree item
function focusOnItem(treeItem, isHighlighted) {
    makeVisible(treeItem);
    var anchor = findAnchor(treeItem);
    if (anchor) {
        anchor.focus();
        if (isHighlighted) {
            highlightItem(treeItem);
  		}
  		var expander = getExpander(treeItem);
  		if (expander !== null) {
  		    scrollUntilVisible(anchor.parentNode, SCROLL_HORIZONTAL_AND_VERTICAL);
  		} else {
  		    scrollUntilVisible(anchor, SCROLL_HORIZONTAL_AND_VERTICAL);
  		}
    }
}

// Highlight the text for a tree item
function highlightItem(treeItem) {
    var anchor = findAnchor(treeItem);
    if (anchor) {
  	  	if (oldActive) {
  	  		oldActive.className = oldActiveClass;
        }
  		oldActive = anchor;
  		oldActiveClass = anchor.className;
  		anchor.className = "active";
    }
}

// Force an items parents to be visible
function makeVisible(treeItem) {
    var parent = getTreeItem(treeItem.parentNode);
    if (!parent) {
        return;
    } 
    if (parent.className != "root") {
        makeVisible(parent); 
    }  
    var childClass = getChildClass(parent);    
    if (childClass == "hidden" ) {
        toggleExpandState(parent);
     }     
}

// The tree consists of tree items which can be nested or in sequences
// Each tree item is a DIV node which contains an expander for non-leaf nodes as
// well as an anchor containing an image and text. Non-leaf nodes use a <SPAN> to contain
// the expander and anchor to prevent line breaking, they also contain
// a DIV to hold their children. 

function getTreeItem(node) {
    if (node === null) {
        return null;
    }
    for (var candidate = node; candidate !== null; candidate = candidate.parentNode) {
        if (candidate.tagName == "DIV") {
            var className = candidate.className;
            if (className == "visible" || className == "hidden" || className == "unopened" || className == "root") {
                return candidate;
            }
        }
    }
    return null;
}

// Get the top level item in this tree
// Do this by visiting parent nodes until we hit the root of the tree
function getTopAncestor(node) {
    var candidate = node;
    var next = candidate; 
    while (next !== null && next.className != "root") {
        candidate = next;
        next = getTreeItem(candidate.parentNode);
        if (next.className == "root") {   
            return next;
        }
    }
    return candidate;
}

// The type of a treeItem can be determined from the class of it's DIV children.
// The possible return values are leaf, visible, hidden, unopened
// If there are no children this is a leaf, otherwise return the class of the first child 

function getChildClass(node) {
    var child = findChild(node, "DIV");
    if (child && child.className == "group") {
        child = findChild(child, "DIV");
    }
    if (child) { 
        return child.className; 
    }
    return "leaf";
}

// Get the image node from a DIV representing a tree item
function getIcon(treeItem) {
    var anchor = findAnchor(treeItem);
    if (anchor) {
        return findChild(anchor, "IMG");
    }
    return null;
}

// Return the first child with this tag
function findChild(node, tag) {
    if (node === null) {
        return null;
    }
    var children = node.childNodes;
    for (var i = 0; i < children.length; i++) {
        if (tag == children[i].tagName ) {
            return children[i];
        }
    }
    return null;
}

// Return the last child with this tag
function findLastChild(node, tag) {  
    if (node === null) {
        return null;
    }
    var children = node.childNodes;
    for (var i = children.length - 1; i >= 0; i--) {
        if (tag == children[i].tagName ) {
            return children[i];
        } 
    }
    return null;
}

function getExpander(treeItem) {    
    var imgContainer = findChild(treeItem, "SPAN");
    if (!imgContainer) { imgContainer = treeItem; }
    var children = imgContainer.childNodes;
    var done = false;
    for (var i = 0; i < children.length && !done; i++) {
        if (children[i].className == "expander") {
            return children[i];
        }
    }
    return null;
}

function toggleExpandState(node) {
    var treeItem = getTreeItem(node);
    if (!treeItem) { return; } 
    var oldChildClass = getChildClass(treeItem);
    var newChildClass;
    
    if (oldChildClass == "unopened") {      
        newChildClass = "visible";
        loadChildren(treeItem);
    } else if (oldChildClass == "hidden") {
        newChildClass = "visible";
    } else if (oldChildClass == "visible") {
        newChildClass = "hidden";
    } else {
        return;
    }

    if (oldChildClass != "unopened") {
        var group = findChild(treeItem, "DIV");
        if (group && group.className == "group") {
            // set the childrens class to the new class
            var children = group.childNodes;
            for (var i = 0; i < children.length; i++) {
                if ("DIV" == children[i].tagName ) {
                    children[i].className = newChildClass;
                }
            }
        }   
        changeExpanderImage(treeItem, newChildClass == "visible"); 
    }
    
    setWAIExpansionState(treeItem, newChildClass == "visible");
    
    if (newChildClass == "visible") {
        scrollUntilVisible(treeItem, SCROLL_HORIZONTAL_AND_VERTICAL); 
    } 
}

function changeExpanderImage(treeItem, isExpanded) {
    var icon = getIcon(treeItem);
    var expander = getExpander(treeItem);   
    if (expander) {
        if (isExpanded) {
            setImage(expander, "minus");
        } else {
            setImage(expander, "plus");
        }
    }
    if (icon) {
        updateImage(icon, isExpanded);
    }
}

// Accessibility

var isNamespaceSupport = typeof document.documentElement.setAttributeNS != 'undefined';

function setAccessibilityRole(node, role) {
    if (isNamespaceSupport) {
        node.setAttributeNS("http://www.w3.org/TR/xhtml2", "role", role);
        node.role = role;
    }
}

function setWAIExpanded(node, value) {
    if (isNamespaceSupport) {
        var valueAsString = value? "true" : "false";
        node.setAttributeNS("http://www.w3.org/2005/07/aaa", "expanded", valueAsString);
    }
}

function setRootAccessibility() {
    if (isNamespaceSupport) {
        var treeItem = document.getElementById("tree_root");
        if (treeItem) {
            setAccessibilityRole(treeItem, WAI_TREE);
        }
        var applicationItem = document.getElementById("wai_application");
        if (applicationItem) {
            setAccessibilityRole(applicationItem, WAI_APPLICATION);
        }
    }
}

function setWAIExpansionState(treeItem, isExpanded) { 
    if (isNamespaceSupport) {
        var anchor = findAnchor(treeItem);
        if (anchor) {
            setWAIExpanded(anchor, isExpanded);
        }
    }
}