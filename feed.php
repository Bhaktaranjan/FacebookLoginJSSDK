<!DOCTYPE html>
<html>
<head>
<title>Facebook Login</title>
<link rel="stylesheet" href="bootstrap.min.css">
<style>
    #fb-btn, #logout{
        margin-top: 10px;
    }
    #profile, #logout {
        display: none;
    }
</style>
</head>
<body>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '247843779730948',
      cookie     : true,
      xfbml      : true,
      version    : 'v6.0'
    });
      
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

   function statusChangeCallback(response) {  // Called with the results from FB.getLoginStatus().
    console.log('statusChangeCallback');
    console.log(response);                   // The current login status of the person.
    if (response.status === 'connected') {   // Logged into your webpage and Facebook.
      setElements(true);
      testApi();
      console.log('Loggedin and authenticated!');  
    } else {                                 // Not logged into your webpage or we are unable to tell.
        console.log('Not authenticated!');
        setElements(false)
    }
  }

  function checkLoginState() {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
  }

  function testApi() {
      console.log('API called');
      FB.api('/me?fields=name,email,picture', function(response) {
          if (response && !response.error) {
              buildProfile(response);
          }
      })
  }

  function buildProfile(user) {
      let profile = `
      <h3>${user.name}</h3>
      <ul class=list-group'>
        <li class="list-group-item">User Id: ${user.id}</li>
        <li class="list-group-item">Email: ${user.email}</li>
        <li class="list-group-item">
            <img src="${user.picture.data.url}" alt="" height="${user.picture.data.height}" width="${user.picture.data.width}">
        </li>
      </ul>
      `;
      document.getElementById('profile').innerHTML=profile;
  }

  function setElements(isLoggedIn) {
      if (isLoggedIn) {
        console.log('login-true');
        document.getElementById('profile').style.display='block';
        document.getElementById('fb-btn').style.display='none';
        document.getElementById('logout').style.display='block';
      } else {
        document.getElementById('profile').style.display='none';
        document.getElementById('fb-btn').style.display='block';
        document.getElementById('logout').style.display='none';
      }
  }

  
</script>

<nav class="navbar navbar-expand-md navbar-default bg-dark">
  <a class="navbar-brand" href="index.php">Social Login</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active" id="logout">
            <a href="#" onclick="logout();">Logout</a>
      </li>
      <li class="nav-item active" id='fb-btn'>
            <fb:login-button 
                scope="public_profile,email"
                onlogin="checkLoginState();">
            </fb:login-button>
      </li>
      
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
<div class="">
    <!-- <h3 id="heading">Login to view your profile!</h3> -->
    <div id="profile">
        Login to view your Profile!
    </div>
</div>
</body>
</html>