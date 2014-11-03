// Cleanup functions for the document ready method
if ( document.addEventListener ) {
    DOMContentLoaded = function() {
        document.removeEventListener( "DOMContentLoaded", DOMContentLoaded, false );
        onReady();
    };
} else if ( document.attachEvent ) {
    DOMContentLoaded = function() {
        // Make sure body exists, at least, in case IE gets a little overzealous
        if ( document.readyState === "complete" ) {
            document.detachEvent( "onreadystatechange", DOMContentLoaded );
            onReady();
        }
    };
}
if ( document.readyState === "complete" ) {
    // Handle it asynchronously to allow scripts the opportunity to delay ready
    setTimeout( onReady, 1 );
}

// Mozilla, Opera and webkit support this event
if ( document.addEventListener ) {
    // Use the handy event callback
    document.addEventListener( "DOMContentLoaded", DOMContentLoaded, false );
    // A fallback to window.onload, that will always work
    window.addEventListener( "load", onReady, false );
    // If IE event model is used
} else if ( document.attachEvent ) {
    // ensure firing before onload,
    // maybe late but safe also for iframes
    document.attachEvent("onreadystatechange", DOMContentLoaded);

    // A fallback to window.onload, that will always work
    window.attachEvent( "onload", onReady );
}

function onReady( ) {
  document.getElementById('widgetwci').innerHTML = wciwidgetcode;
}