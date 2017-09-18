// window.onload = function () {
//     if (typeof history.pushState === "function") {
//         history.pushState("jibberish", null, null);
//         console.log(history);
//         window.onpopstate = function () {
//             alert('back button pushed')
//             // history.pushState('newjibberish', null, null);
//             // Handle the back (or forward) buttons here
//             // Will NOT handle refresh, use onbeforeunload for this.
//         };
//     }
//     else {
//         var ignoreHashChange = true;
//         window.onhashchange = function () {
//             if (!ignoreHashChange) {
//                 ignoreHashChange = true;
//                 window.location.hash = Math.random();
//                 // Detect and redirect change here
//                 // Works in older FF and IE9
//                 // * it does mess with your hash symbol (anchor?) pound sign
//                 // delimiter on the end of the URL
//             }
//             else {
//                 ignoreHashChange = false;
//             }
//         };
//     }
// }

// window.onload = function(){
//   window.addEventListener('popstate', function(event) {
//       // The popstate event is fired each time when the current history entry changes.
//
//       var r = confirm("You pressed a Back button! Are you sure?!");
//
//       if (r == true) {
//           // Call Back button programmatically as per user confirmation.
//           history.back();
//           // Uncomment below line to redirect to the previous page instead.
//           // window.location = document.referrer // Note: IE11 is not supporting this.
//       } else {
//           // Stay on the current page.
//           history.pushState(null, null, window.location.pathname);
//       }
//
//       history.pushState(null, null, window.location.pathname);
//
//   }, false);
// }
