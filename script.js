let url = 'https://newsdata.io/api/1/news?apikey=';
let API_KEY = apiKeyData[0];
let api_key_tracker = 0;
let nextPageId = null;

async function fetchNews(category,requiredArticles=5,json=[]) {
    localStorage.removeItem("newsArticles");
    loadBtn = document.querySelector("#loadMoreBtn");
    document.getElementById("footer").removeAttribute("style");
    document.getElementById("main").innerHTML = "";
    loadBtn.innerHTML = "Loading";
    let result;
    if(category == "Latest News"){
        result = await fetch(url + API_KEY + `&country=in&language=en`);
    }
    else{
        result = await fetch(url + API_KEY + `&country=in&language=en&category=`+category);
        console.log("Fetch : Category");
    }

    let response_code = result.status;
    let data = await result.json();
    console.log("FetchNews : ",data);
    console.log("Response Code : ",response_code);

    if(response_code == 429){
        api_key_tracker = (api_key_tracker + 1) % 42;
        API_KEY = apiKeyData[api_key_tracker];
        fetchNews(category);
    }
    else if(response_code == 422){
        document.write("Something Went Wrong !!");
    }

    else{
        if(data.nextPage != null){
            nextPageId = data.nextPage;
            loadBtn.innerHTML = "Load More";
            loadBtn.setAttribute("style", "display : block");
        }
        else{
            loadBtn.setAttribute("style","display : none");
            nextPageId = null;
        }
    
        data = data.results;
        let noOfArticles = 0;
        for(let i=0; i<data.length; i++){
            if (!(data[i].image_url === null || data[i].description === null || data[i].title === null || data[i].content === null)) {
                noOfArticles++;
                json.push(data[i]);
            }
        }

        if((requiredArticles - noOfArticles > 0) && nextPageId != null){
            loadMoreNews(category,requiredArticles-noOfArticles,json);
        }
        else{
            toLocalStorage(json);
            fillNews();
        }
    }
}

function fillNews() {
    let data = JSON.parse(localStorage.getItem("newsArticles"));

    document.getElementById("main").innerHTML = '';
    for (let i = 0; i < data.length; i++) {
        for (let j = 0; j < data[i].length; j++) {
            let creatorDetails = data[i][j].creator;

            if (creatorDetails == null)
                creatorDetails = `<b>Anonymous</b> &bull; `+ data[i][j].pubDate.slice(0, 10);
            else
                creatorDetails = `<b>`+data[i][j].creator+`</b> &bull; `+ data[i][j].pubDate.slice(0, 10);

            // Id for news card elements
            let news_article_id = data[i][j].article_id;

            document.getElementById("main").innerHTML +=
                `<div class="news-card" id='`+ news_article_id + `'onclick="document.location.href='`+data[i][j].link+`'">
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
    document.getElementById("goToTopIcon").innerHTML = `<a href="#"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>`;
    document.getElementById("loadMoreBtn").setAttribute("onclick",`loadMoreNews("`+document.getElementById(currentCategory).innerHTML+`")`);
    document.getElementById("footer").setAttribute("style","display : block");
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
    }
}

async function loadMoreNews(category,requiredArticles=5,json=[]) {
    let loadBtn = document.querySelector("#loadMoreBtn");
    
    document.getElementById("footer").removeAttribute("style");
    loadBtn.innerHTML = "Loading";

    let result;
    if(category == "Latest News")
        result = await fetch(url + API_KEY + `&country=in&language=en&page=`+nextPageId);
    else
        result = await fetch(url + API_KEY + `&country=in&language=en&category=`+category+`&page=`+nextPageId);

    let response_code = result.status;
    let data = await result.json();
    
    if(response_code == 429){
        api_key_tracker = (api_key_tracker + 1) % 42;
        API_KEY = apiKeyData[api_key_tracker];
        loadMoreNews(category,requiredArticles,json);
    }
    else if(response_code == 422){
        document.write("Something Went Wrong !!");
    }
    else{
        console.log("Load More data : ",data);
        if(data.nextPage != null){
            nextPageId = data.nextPage;
            loadBtn.setAttribute("style", "display : block");
            loadBtn.innerHTML = "Load More";
        }
        else{
            nextPageId = null;
            loadBtn.setAttribute("style","display : none");
        }
    
        data = data.results;
        
        let noOfArticles = 0;
        for(let i=0; i<data.length; i++){
            if (!(data[i].image_url === null || data[i].description === null || data[i].title === null || data[i].content === null)) {
                noOfArticles++;
                json.push(data[i]);
            }
        }
        if((requiredArticles - noOfArticles > 0) && nextPageId != null){
            loadMoreNews(category,requiredArticles-noOfArticles,json);
        }
        else{
            toLocalStorage(json);
            fillNews();
        }
    }
}