fetch('./server/config/core.php').then((response) =>{
    response.text().then((text) => {
        console.log(text);
    })
});