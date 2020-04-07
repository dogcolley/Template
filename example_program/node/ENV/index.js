process.env.NODE_ENV= 'production';

process.env.NODE_ENV = ( process.env.NODE_ENV && ( process.env.NODE_ENV ).trim().toLowerCase() == 'production' ) ? 'production' : 'development';



if (process.env.NODE_ENV == 'production') {
    console.log("Production Mode");
  } else if (process.env.NODE_ENV == 'development') {
    console.log("Development Mode");
  }

