/*******************************************************************************
 * Copyright (c) 2000, 2004 IBM Corporation and others.
 * All rights reserved. This program and the accompanying materials 
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.eclipse.org/legal/epl-v10.html
 * 
 * Contributors:
 *     IBM Corporation - initial API and implementation
 *	   2008/09/11 - updated by Xu Yumei(IBM Corp.) for highlight button state changed
 *******************************************************************************/
 
var isMozilla = navigator.userAgent.indexOf('Mozilla') != -1 && parseInt(navigator.appVersion.substring(0,1)) >= 5;
var isIE = navigator.userAgent.indexOf('MSIE') != -1;

var navVisible = true;
	
function goBack(button, param) {
	parent.history.back();
	if (button && document.getElementById(button)){
		document.getElementById(button).blur();
	}
}

function goForward(button, param) {
	parent.history.forward();
	if (button && document.getElementById(button)){
		document.getElementById(button).blur();
	}
}

function goHome(button, param) {
	var isHome = false;

	try {
		// first check if we're already at home
		var str = param;
		var index = str.indexOf("/");
		if (index > 0) {
			str = str.substring(index);
		}
		var locationStr = parent.ContentViewFrame.location.href;
		isHome = (locationStr.substring(locationStr.length - str.length) == str)
	}
	catch (e) {
		// insufficient permission, not home
	}
	
	if (!isHome) {
		parent.ContentViewFrame.location = param;
	}
	parent.parent.NavFrame.collapseToc();
	if (button && document.getElementById(button)){
		document.getElementById(button).blur();
	}
}

function bookmarkPage(button, param)
{
	// Currently we pick up the url from the content page.
	// If the page is from outside the help domain, a script
	// exception is thrown. We need to catch it and ignore it.
	try
	{
		// use the url from plugin id only
		var url = parent.ContentViewFrame.location.href;
		var i = url.indexOf("/topic/");
		if (i >=0 )
			url = url.substring(i+6);
		// remove any query string
		i = url.indexOf("?");
		if (i >= 0)
			url = url.substring(0, i);
			
		var title = parent.ContentViewFrame.document.title;
		if (title == null || title == "")
			title = url;

		/********** HARD CODED VIEW NAME *************/
		parent.parent.NavFrame.ViewsFrame.bookmarks.bookmarksViewFrame.location.replace("bookmarksView.jsp?operation=add&bookmark="+encodeURIComponent(url)+"&title="+encodeURIComponent(title));
	}catch (e) {}
	if (button && document.getElementById(button)){
		document.getElementById(button).blur();
	}
}

function bookmarkInfocenterPage(button, param)
{
	// Currently we pick up the url from the content page.
	// If the page is from outside the help domain, a script
	// exception is thrown. We need to catch it and ignore it.
	try
	{
		// use the url from plugin id only
		var url = parent.ContentViewFrame.location.href;
		var i = url.indexOf("/topic/");
		if (i >=0 )
			url = url.substring(i+6);
		// remove any query string
		i = url.indexOf("?");
		if (i >= 0)
			url = url.substring(0, i);
			
		var title = parent.ContentViewFrame.document.title;
		if (title == null || title == "")
			title = url;

		/********** HARD CODED VIEW NAME *************/
		window.external.AddFavorite(parent.ContentViewFrame.location.href,title);
	}catch (e) {}
	if (button && document.getElementById(button)){
		document.getElementById(button).blur();
	}
}

function getCurrentTopic() {
    var topic = parent.ContentViewFrame.window.location.href;
	// remove the query, if any
	var i = topic.indexOf('?');
	if (i != -1) {
		topic = topic.substring(0, i);
	}
	return topic;
}

function resynch(button, param)
{
	try {
		parent.parent.NavFrame.displayTocFor(getCurrentTopic(), false);
	} catch(e) {}
	if (button && document.getElementById(button)){
		document.getElementById(button).blur();
	}
}

// Synchronize after a hyperlink is selected

function autosynch() {
    try {
		parent.parent.NavFrame.displayTocFor(getCurrentTopic(), true);
	} catch(e) {}
}

function toggleHighlight(button, param)
{
	try {
		parent.ContentViewFrame.toggleHighlight();
		var highlight = parent.ContentViewFrame.currentHighlight;
		window.setButtonState("toggle_highlight",highlight); // modyfi for highlight button state changed
		if(highlight == true){
			document.getElementById("toggle_highlight").setAttribute("title", highlightButtonTooltipOff);
		    document.getElementById("toggle_highlight").setAttribute("alt", highlightButtonTooltipOff);
		}else{
			document.getElementById("toggle_highlight").setAttribute("title", highlightButtonTooltipOn);
		    document.getElementById("toggle_highlight").setAttribute("alt", highlightButtonTooltipOn);
		}
		var date = new Date();
		date.setTime(date.getTime()+(365*24*60*60*1000));
		document.cookie = document.cookie = "highlight="+highlight+"; expires="+date.toGMTString() + ";path=/";;
		
	} catch(e) {}
	if (button && document.getElementById(button)){
		document.getElementById(button).blur();
	}
}

function printContent(button, param)
{
	try {
		parent.ContentViewFrame.focus();
		parent.ContentViewFrame.print();
	} catch(e) {}
	if (button && document.getElementById(button)){
		document.getElementById(button).blur();
	}
}
