// Initialize Firebase
var config = {
    apiKey: "AIzaSyAqncKfGXflDEHDjb1tDtpv774Mx4-uPxA",
    authDomain: "bargain-savethehacker.firebaseapp.com",
    databaseURL: "https://bargain-savethehacker.firebaseio.com",
    projectId: "bargain-savethehacker",
    storageBucket: "bargain-savethehacker.appspot.com",
    messagingSenderId: "297593885788"
};
firebase.initializeApp(config);

function fblogin() {
    var provider = new firebase.auth.FacebookAuthProvider();
    provider.addScope('public_profile');

    provider.setCustomParameters({
        'display': 'popup'
    });

    firebase.auth().signInWithPopup(provider).then(function(result) {
        // This gives you a Facebook Access Token. You can use it to access the Facebook API.
        var token = result.credential.accessToken;
        // The signed-in user info.
        var user = result.user;
        // ...
        console.log(user);
        console.log("UID : " + user.providerData["0"].uid);
    }).catch(function(error) {
        // Handle Errors here.
        var errorCode = error.code;
        var errorMessage = error.message;
        // The email of the user's account used.
        var email = error.email;
        // The firebase.auth.AuthCredential type that was used.
        var credential = error.credential;
        // ...
    });
}

firebase.auth().onAuthStateChanged(function(user) {
  if (user) {
    console.log(user);
    document.getElementById("uid").innerHTML = user.displayName;

    document.getElementById("uid").value = user.providerData["0"].uid;
  } else {
    // No user is signed in.
  }
});
