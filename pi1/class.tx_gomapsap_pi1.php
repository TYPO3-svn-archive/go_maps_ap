<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Marc Hirdes <hirdes@zwo-null.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Google Maps Input' for the 'go_maps_ap' extension.
 *
 * @author	Marc Hirdes <hirdes@zwo-null.de>
 * @package	TYPO3
 * @subpackage	tx_gomapsap
 */
class tx_gomapsap_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_gomapsap_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_gomapsap_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'go_maps_ap';	// The extension key.
	var $pi_checkCHash = true;
	
	var $addrList = array();
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
	
		// parse XML data into php array
		$this->pi_initPIflexForm();
		
		// get the values
		$this->mapTitle		 	= $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'map_title', 'sKARTE');
		$this->mapTooltip 		= $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'map_tooltip', 'sKARTE');
		$this->mapClass 		= $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'map_class', 'sKARTE');
		$this->mapHeight 		= $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'map_height', 'sKARTE');
		$this->mapWidth 		= $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'map_width', 'sKARTE');
		$this->zoom	 			= $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'zoom', 'sKARTE');
		$this->adressen 		= $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'adressen', 'sKARTE');
		$this->route	 		= $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'route', 'sDEF');
		$this->zoomscroll	 	= $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'zoomscroll', 'sDEF');
		$this->dragging	 		= $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'dragging', 'sDEF');
		$this->zoomdoubleclick	= $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'zoomdoubleclick', 'sDEF');
		$this->zoombar	 		= $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'zoombar', 'sDEF');
		$this->zoombarselect	= $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'zoombarselect', 'sDEF');
		$this->mapmodi	 		= $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'mapmodi', 'sDEF');
		$this->mapmodiselect	= $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'mapmodiselect', 'sDEF');
		
		$content = '';
		$content .=' <script src="http://maps.google.com/maps?file=api&amp;v=3&amp;key='.$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$this->extKey]['mapKey'].'" type="text/javascript"></script>'; 
		
		$whereClause = 'uid IN ('.$this->adressen.') AND deleted = 0';
		$addrListResult = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*','tx_gomapsap_adress',$whereClause,'','uid');
		$addrList = array();
		$adressen = array();		
		if($addrListResult){
			while ($addrListLine = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($addrListResult)){
				$addrList = $addrListLine;
				$adresse = "
				var pointDescription = {
				 'imageFilename' 		: '" . $addrList['image'] ."',
				 'imageResizeMarker' 	: " . $addrList['imagesize'] .",
				 'imageResizeWidth' 	: " . $addrList['imagewidth'] .",
				 'imageResizeHeight' 	: " . $addrList['imageheight'] .",
				 'imageShadowFilename' 	: '" . $addrList['shadow'] ."',
				 'imageResizeShadow' 	: " . $addrList['shadowsize'] .",
				 'imageResizeShadowWidth' 	: " . $addrList['shadowwidth'] .",
				 'imageResizeShadowHeight' 	: " . $addrList['shadowheight'] .",
				 'text' 				: '" . nl2br($addrList['text']) ."',
				 'address'				: '" . $addrList['adress'] . "'
				};
				addMapPoint(pointDescription, Route, element);";
				$adressen[] = $adresse;
			}
		};
		
				$content .= '<div class="'.$this->mapTitle.'"> </div>';
				$content .= '<script language="Javascript">
	
function addMapPoint(pointDescription, Route, element){
		    Route.push(pointDescription.address);
		    element.geocoder.getLatLng(pointDescription.address, function(point) {
		   	 if(pointDescription.imageFilename != ""){
				 var Icon = new GIcon(G_DEFAULT_ICON, "uploads/tx_gomapsap/"+pointDescription.imageFilename);
				 if(pointDescription.imageResizeMarker == 1) {
					Icon.iconSize = new GSize(pointDescription.imageResizeWidth, pointDescription.imageResizeHeight);
					Icon.iconAnchor = new GPoint((pointDescription.imageResizeWidth/2), pointDescription.imageResizeHeight);
      				Icon.infoWindowAnchor = new GPoint((pointDescription.imageResizeWidth/2), 0);
      				Icon.imageMap = [0,0,pointDescription.imageResizeWidth,0,pointDescription.imageResizeWidth,pointDescription.imageResizeHeight,0,pointDescription.imageResizeHeight,0,0];
				}
				 if (pointDescription.imageShadowFilename != "") 
					Icon.shadow = "uploads/tx_gomapsap/" + pointDescription.imageShadowFilename;
				 if(pointDescription.imageResizeShadow == 1)
					Icon.shadowSize= new GSize(pointDescription.imageResizeShadowWidth, pointDescription.imageResizeShadowHeight);
			 	 var marker = new GMarker(point, Icon);
				}else{
				 var marker = new GMarker(point);
			};
			if(pointDescription.text != ""){
		  	 	 GEvent.addListener(marker, "mouseover", function() {
					marker.openInfoWindowHtml(pointDescription.text);
			});
			GEvent.addListener(marker, "mouseout", function() {
		         	marker.closeInfoWindow();
             	  	});
             	     };
             			  			  	  
			element.map.addOverlay(marker);			  
			element.bounds.extend(point);
			element.map.setZoom(element.map.getBoundsZoomLevel(element.bounds)' . ($this->zoom?'-'.$this->zoom:'') . ');
               		element.map.setCenter(element.bounds.getCenter());
               		element.map.checkResize();
		  })
}								
								
					(function initMap(){
					  window.addEvent(\'domready\', function(){							   
							$each($$(".'.$this->mapTitle.'"), function(element, index){
								var Route = new Array();								
								var pointDescriptions = Array();
								var mapElement = new Element(\'div\', {"title": \''.$this->mapTooltip.'\', "class":\''.$this->mapClass.'\', "style": \'width: '.$this->mapWidth.'px; height: '.$this->mapHeight.'px; overflow:hidden;\'});
								if (GBrowserIsCompatible()) {
					        		element.map = new GMap2(mapElement,{ size: new GSize('.$this->mapWidth.','.$this->mapHeight.')});
									element.map.setCenter(new GLatLng(0,0), 1);';
									if($this->dragging==0)
										$content .= 'element.map.disableDragging();'; 
									if($this->zoomdoubleclick==0){
										$content .= 'element.map.disableDoubleClickZoom();';
									}else{
										$content .= 'element.map.enableDoubleClickZoom();';
									}
									if($this->zoomscroll==1)
										$content .= 'element.map.enableScrollWheelZoom();';									
									if($this->zoombar==1){
										if($this->zoombarselect==0)
											$content .= 'element.map.addControl(new GSmallZoomControl());';
										if($this->zoombarselect==2)
											$content .= 'element.map.addControl(new GSmallMapControl());';
										if($this->zoombarselect==3)	
											$content .= 'element.map.addControl(new GLargeMapControl());';
									}
									if($this->mapmodi==1)
										$content .= 'element.map.setMapType(G_SATELLITE_MAP);';
									if($this->mapmodi==2)
										$content .= 'element.map.setMapType(G_HYBRID_MAP);';
									if($this->mapmodiselect==1)
										$content .= 'element.map.addControl(new GMapTypeControl());';
									$content .= '
									element.geocoder = new GClientGeocoder();
									element.bounds = new GLatLngBounds();
									if (element.geocoder) {';	
									
					
					foreach ($adressen as $adresse) {
							$content .= $adresse;
					};
					
					if($this->route==1){					
						$content .= '
						GEvent.addListener(element.map, "click", function() {
					   		window.open("http://maps.google.de/maps?f+=d&source=s_d&saddr="+Route[0]+"&daddr="+Route[1]+"&hl=de&ie=UTF8", "Navigation", \'fullscreen=yes, scrollbars=auto\');
				        });';	
				        }	      				  
					      
						// element einf�gen
				       $content .= '
					   mapElement.inject(element, "before");
				 }
			}
		 });
	   });
  })();
		';
		$content.= '</script>';
		/*	}
		};*/
		
		//
		
		
	
		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/go_maps_ap/pi1/class.tx_gomapsap_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/go_maps_ap/pi1/class.tx_gomapsap_pi1.php']);
}

?>