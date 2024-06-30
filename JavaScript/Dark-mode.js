// Wrap everything inside a window.onload event to make sure the DOM is fully loaded before accessing elements
window.onload = function() {
    // Get the modal
    var modal = document.getElementById("myModal");
  
    // Get the button that opens the modal
    var btn = document.getElementById("openModalBtn");
    var btn2 = document.getElementById("openModalBtn2");
  
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
  
    // When the user clicks the button, open the modal
    btn.onclick = function() {
      modal.style.display = "block";
    }
    // When the user clicks the button, open the modal
    btn2.onclick = function() {
        modal.style.display = "block";
    }
    
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    }
  
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  };

document.addEventListener('DOMContentLoaded', function() {
    // Get references to the moon and sun emoji elements
    const moonEmoji = document.getElementById('moon');
    const sunEmoji = document.getElementById('sun');
    top = document.getElementById('Top');
    buttom = document.getElementById('regular-display');

    // Add click event listeners to toggle dark mode
    moonEmoji.addEventListener('click', function() {
        document.body.classList.add('dark-mode');
        var divs = document.getElementsByClassName('dark');
        for (var i = 0; i < divs.length; i+=2){
        divs[i].style.backgroundColor = newColor;}
    });

    sunEmoji.addEventListener('click', function() {
        
        document.body.classList.remove('dark-mode');
    });
});

function changeDivColor(divClassName, newColor) {
    var divs = document.getElementsByClassName(divClassName);
    for (var i = 0; i < divs.length; i++) {
        divs[i].style.backgroundColor = newColor;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Get references to the moon and sun emoji elements
    const moonEmoji = document.getElementById('moon');
    const sunEmoji = document.getElementById('sun');
    const divs = document.getElementsByClassName('dark');
    const con_edge = document.querySelectorAll('header'); // Selecting divs with class edge-container
    const sections = document.querySelectorAll('section'); // Selecting all sections
    const NavBar = document.querySelectorAll('nav');
    const topDiv = document.getElementById('top_div');
    const tex = document.querySelectorAll('input');
    const tex2 = document.querySelectorAll('textarea');
    const h_3 = document.querySelectorAll('h3');
    const Dlabel = document.querySelectorAll('label');
    const linkText = document.querySelectorAll('a');
    const sectionOriginalColors = []; // Array to store original background colors of sections
    const originalColors = []; // Array to store original background colors of divs
    let count = 0;

     // Store original background colors of divs
     for (let i = 0; i < divs.length; i++) {
        originalColors.push(divs[i].style.backgroundColor);
     }
 

    // Add click event listeners to toggle dark mode
    moonEmoji.addEventListener('click', function() {
        document.body.classList.add('dark-mode');

        for (let i = 0; i < divs.length; i++) {
            divs[i].style.backgroundColor = 'darkslategray';
        }
        count++;
        if (count == divs.length) {
            count = 0;
        }
        divs[count].style.backgroundColor = 'darkteal';

        // Change background image colors of sections to darker ones
        sections.forEach(function(section) {
            section.classList.add('dark-gradient'); // Add the class for darker gradient
        });
        
        // Add the class for darker version to edge containers
        con_edge.forEach(function(article) {
            article.classList.add('Dark-edge-container');
        });

        NavBar.forEach(function(nav) {
            nav.classList.add('dark-mode-NavB');
        })

        topDiv.classList.add('dark-mode-NavB');

        tex.forEach(function(input) {
            input.classList.add('dark-text-box');
        })
        tex2.forEach(function(textarea) {
            textarea.classList.add('dark-text-box');
        })

        h_3.forEach(function(h3) {
            h3.classList.add('h3-dark');
        })

        Dlabel.forEach(function(label){
            label.classList.add('label-dark');
        })

        linkText.forEach(function(a) {
            a.classList.add('cyan-text');
        })

    });

    sunEmoji.addEventListener('click', function() {
        document.body.classList.remove('dark-mode');
        for (let i = 0; i < divs.length; i++) {
            divs[i].style.backgroundColor = originalColors[i]; // Reset background color
        }
        count = 0; // Reset count

        // Restore original background color of sections
        sections.forEach(function(section, index) {
            section.classList.remove('dark-gradient');
        
        });

    // Remove the class for darker version from edge containers
    con_edge.forEach(function(article) {
        article.classList.remove('Dark-edge-container');
    });

    NavBar.forEach(function(nav) {
        nav.classList.remove('dark-mode-NavB');
    })

    topDiv.classList.remove('dark-mode-NavB'); // Remove the 'dark-mode-NavB' class from the selected element

    tex.forEach(function(input) {
        input.classList.remove('dark-text-box');
    })
    tex2.forEach(function(textarea) {
        textarea.classList.remove('dark-text-box');
    })
    h_3.forEach(function(h3) {
        h3.classList.remove('h3-dark');
    })

    Dlabel.forEach(function(label){
        label.classList.remove('label-dark');
    })
    linkText.forEach(function(a) {
        a.classList.remove('cyan-text');
    })
  });
});
