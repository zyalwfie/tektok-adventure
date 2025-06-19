/*
Template Name: Admin Template
Author: Wrappixel

File: js
*/
// ==============================================================
// Auto select left navbar
// ==============================================================
$(function () {
  "use strict";
  
  document.querySelectorAll("#sidebarnav a").forEach(function (link) {
    link.addEventListener("click", function (e) {
      const isActive = this.classList.contains("active");
      const parentUl = this.closest("ul");
      if (!isActive) {
        
        // hide any open menus and remove all other classes
        parentUl.querySelectorAll("ul").forEach(function (submenu) {
          submenu.classList.remove("in");
        });

        // open our new menu and add the open class
        const submenu = this.nextElementSibling;
        if (submenu) {
          submenu.classList.add("in");
        }

      } else {
        const submenu = this.nextElementSibling;
        if (submenu) {
          submenu.classList.remove("in");
        }
      }
    });
  });

});