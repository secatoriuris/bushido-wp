window.addEventListener(
  "scroll",
  function() {
    if (document.documentElement.scrollTop>50) {
      document.getElementById("navbar").classList.add("shrink-navbar");
      document.getElementById("menu-main-menu").classList.add("shrink-menu");
      document.getElementById("mobile-nav-button").classList.add("shrink-nav-button");


  } else {
      document.getElementById("navbar").classList.remove("shrink-navbar");
      document.getElementById("menu-main-menu").classList.remove("shrink-menu");
      document.getElementById("mobile-nav-button").classList.remove("shrink-nav-button");


  }
},
false
);
