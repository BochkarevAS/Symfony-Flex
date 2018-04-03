'use strict';

let movieList = document.getElementById('movies');

function addMovies(movie) {
    let img = document.createElement('img');
    img.src = movie.Poster;
    movieList.appendChild(img);
}

function getData(url) {

    return new Promise((resolve, reject) => {
        let xhr = new XMLHttpRequest();
        xhr.open('GET', url);

        xhr.onload = function () {
            if (xhr.status === 200) {
                let json = JSON.parse(xhr.response);
                resolve(json.Search);
            } else {
                reject(xhr.statusText);
            }
        };

        xhr.onerror = function (error) {
            reject(error);
        };

        xhr.send();
    });
}

let batman = getData('http://www.omdbapi.com/?i=tt3896198&apikey=73a9858a&s=batman');
let spiderman = getData('http://www.omdbapi.com/?i=tt3896198&apikey=73a9858a&s=spider man');

batman
    .then((movies) => {
        movies.forEach((movie) => { addMovies(movie) })
    }).catch((error) => {
        console.error(error);
    });

spiderman
    .then((movies) => {
        movies.forEach((movie) => { addMovies(movie) })
    }).catch(function (error) {
        console.error(error);
    });

function go(num) {

    return new Promise(function (resolve, reject) {
        let delay = Math.ceil(Math.random() * 3000);

        console.log(num, delay);

        setTimeout(function () {
            if (delay < 2000) {
                resolve(num);
            } else {
                reject(num);
            }
        }, delay)
    });
}

let list = [go(1), go(2), go(3)];

Promise.all(list)
    .then((value) => {
        console.log(value);
    }).catch((error) => {
        console.error(error);
    });





