let url = 'https://newsapi.org/v2/top-headlines?';
let API_KEY = apiKeyData[0];
let api_key_tracker = 0;
let nextPageId = undefined;
let currentCategory = undefined;

async function fetchNews(category,requiredArticles=5,json=[]) {
    loadBtn = document.querySelector("#loadMoreBtn");
    let result = await fetch(`https://newsdata.io/api/1/news?apikey=` + API_KEY + `&country=in&language=en&category=`+category);
    let data = await result.json();
    console.log("FetchNews : ",data);
    console.log(data.status);
    if(data.status == "success"){
        if(data.nextPage != null){
            nextPageId = data.nextPage;
            loadBtn.innerHTML = "Load More";
            loadBtn.setAttribute("style", "display : block");
        }
        else{
            loadBtn.setAttribute("style","display : none");
            nextPageId = undefined;
        }
    
        data = data.results;
        let noOfArticles = 0;
        for(let i=0; i<10; i++){
            if (!(data[i].image_url === null || data[i].description === null || data[i].title === null || data[i].content === null)) {
                noOfArticles++;
                json.push(data[i]);
            }
        }

        if((requiredArticles - noOfArticles > 0) && nextPageId != undefined){
            fetchNews(category,requiredArticles-noOfArticles,json);
        }
        else{
            localStorage.clear();
            toLocalStorage(json);
            fillNews();
        }
    }
    else{
        console.log("failure !!");
        api_key_tracker = (api_key_tracker + 1) % 42;
        API_KEY = apiKeyData[api_key_tracker];
        fetchNews(category);
    }
}

function fillNews() {
    let data = JSON.parse(localStorage.getItem("newsArticles"));

    document.getElementsByClassName("main")[0].innerHTML = '';
    for (let i = 0; i < data.length; i++) {
        for (let j = 0; j < data[i].length; j++) {
            let creatorDetails = data[i][j].creator;

            if (creatorDetails == null)
                creatorDetails = `<b>Anonymous</b> &bull; `+ data[i][j].pubDate.slice(0, 10);
            else
                creatorDetails = `<b>`+data[i][j].creator+`</b> &bull; `+ data[i][j].pubDate.slice(0, 10);

            // Id for news card elements
            let news_article_id = data[i][j].article_id;

            document.getElementsByClassName("main")[0].innerHTML +=
                `<div class="news-card" id=` + news_article_id + `>
            <div class="news-card-left">
                <div class="news-provider-info">`+creatorDetails+`</div>
                <div class="news-title">
                    <p>`+ data[i][j].title + `</p>
                </div>
                <div class="news-description">
                    <p>`+ data[i][j].description.slice(0,200) + `...` + `</p>
                </div>
            </div>
            <div class="news-card-right">
                <img src=`+ data[i][j].image_url + ` alt="News-Image" class="news-image">
            </div>
        </div>`
        }
    }
}

function toLocalStorage(data) {
    let storedData = localStorage.getItem("newsArticles");

    if (storedData === null) {
        // If no data exists, create a new array and store it in localStorage
        localStorage.setItem("newsArticles", JSON.stringify([data]));
    } else {
        // If data exists, parse it, update the array, and store it back
        let existingData = JSON.parse(storedData);
        existingData.push(data);
        localStorage.setItem("newsArticles", JSON.stringify(existingData));
        console.log(JSON.parse(localStorage.getItem("newsArticles")))
    }
}

async function loadMoreNews(category,requiredArticles=5,json=[]) {
    let loadBtn = document.querySelector("#loadMoreBtn");
    loadBtn.innerHTML = "Loading";

    let result = await fetch(`https://newsdata.io/api/1/news?apikey=` + API_KEY + `&country=in&language=en&category=`+category+`&page=`+nextPageId);
    let data = await result.json();

    if(data.status == "success"){
        console.log("Load More data : ",data);
        if(data.nextPage != null){
            nextPageId = data.nextPage;
            loadBtn.setAttribute("style", "display : block");
            loadBtn.innerHTML = "Load More";
        }
        else{
            nextPageId = undefined;
            loadBtn.setAttribute("style","display : none");
        }
    
        data = data.results;
        console.log("Main : ",data);
        
        let noOfArticles = 0;
        for(let i=0; i<10; i++){
            if (!(data[i].image_url === null || data[i].description === null || data[i].title === null || data[i].content === null)) {
                noOfArticles++;
                json.push(data[i]);
            }
        }
        if((requiredArticles - noOfArticles > 0) && nextPageId != undefined){
            loadMoreNews(category,requiredArticles-noOfArticles,json);
        }
        else{
            toLocalStorage(json);
            fillNews();
        }
        console.log(noOfArticles);
    }
    else{
        console.log("failure !!");
        api_key_tracker = (api_key_tracker + 1) % 42;
        API_KEY = apiKeyData[api_key_tracker];
        loadMoreNews(category,requiredArticles,json);
    }
}

// fetchNews("Business");