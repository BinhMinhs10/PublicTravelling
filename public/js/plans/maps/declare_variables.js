		var map;
		var directionsService;
		var directionsDisplay;
		var endablePlan = 1;	//	plan can be ended in some cases, end plan menu display only when set endablePlan=1
		var markers = [];	//	the array save all maker on the map
		var displayMarkerMenu = false;	// display menu for marker only when right click on it
		var geocoder = new google.maps.Geocoder();
		var orders = [1];	//	the array save the order of rowindex, ex:[1,9,5,2]
		var currentIndex = 1;	//	the max index of row element id, ex: start9, finis9,...
		Date.prototype.today = function () { 
		    return this.getFullYear() 
		    +"-"+(((this.getMonth()+1) < 10)?"0":"") + (this.getMonth()+1) 
		    +"-"+ ((this.getDate() < 10)?"0":"") + this.getDate();
		}

		Date.prototype.timeNow = function () {
		    return ((this.getHours() < 10)?"0":"") + this.getHours() 
		    +":"+ ((this.getMinutes() < 10)?"0":"") + this.getMinutes();
		     //+":"+ ((this.getSeconds() < 10)?"0":"") + this.getSeconds();
		}
		var newDate = new Date();
		var currentTime = newDate.timeNow();	
		