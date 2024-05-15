// function closeDropdown() {
//   var dropdownToggle = document.querySelector('.dropdown-toggle');
//   var dropdownMenu = document.querySelector('.dropdown-menu');

//   dropdownToggle.setAttribute('aria-expanded', 'false');
//   dropdownMenu.classList.remove('show');
//   dropdownToggle.classList.remove('show');
//     dropdownToggle.disabled = false;

// }

// function openDropdown() {
//   var dropdownToggle = document.querySelector('.dropdown-toggle');
//   var dropdownMenu = document.querySelector('.dropdown-menu');
//   dropdownToggle.setAttribute('aria-expanded', 'true');
//   dropdownMenu.classList.add('show');
// dropdownToggle.disabled = true;
// }

// // Close the dropdown menu when the screen size is less than 992 pixels
// function handleResize() {
//   if (window.innerWidth < 992) {
//     closeDropdown();
//   } else {
//     openDropdown();
//   }
// }

// // Attach event listener on page load
// window.addEventListener('load', function() {
//   handleResize();
//   window.addEventListener('resize', handleResize);
// });



// var dropdownToggle = document.getElementById('dropdownToggle');
// var dropdownMenu = document.getElementById('dropdownMenu');

// dropdownToggle.addEventListener('click', function(event) {
//     event.stopPropagation();
//     dropdownMenu.classList.toggle('show');
// });

// dropdownMenu.addEventListener('click', function(event) {
//     event.stopPropagation();
// });

// document.addEventListener('click', function() {
//     dropdownMenu.classList.remove('show');
// });

// var labels = document.querySelectorAll('.form-check label');
// labels.forEach(function(label) {
//     label.addEventListener('click', function(event) {
//         event.stopPropagation();
//     });
// });


// var dropdownToggle = document.getElementById('dropdown-toggle');
// var dropdownMenu = document.getElementById('dropdown-menu');

// dropdownToggle.addEventListener('click', function(event) {
//     event.stopPropagation();
//     dropdownMenu.classList.toggle('show');
// });

// dropdownMenu.addEventListener('click', function(event) {
//     event.stopPropagation();
// });

// document.addEventListener('click', function() {
//     dropdownMenu.classList.remove('show');
// });
