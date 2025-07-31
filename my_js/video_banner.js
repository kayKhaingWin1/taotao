const videoPlayer = document.getElementById("videoPlayer"); 
const playPauseBtn = document.getElementById("playPauseBtn");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const progressLines = document.querySelectorAll(".video-progress-line");

const videoSources = [
    "https://ia600907.us.archive.org/27/items/banner1_202507/banner1.mp4",
    "https://ia903102.us.archive.org/12/items/banner3_202507/banner2.mp4",
    "https://ia903102.us.archive.org/12/items/banner3_202507/banner3.mp4",
    "https://ia903102.us.archive.org/12/items/banner3_202507/banner4.mp4"
];

let currentIndex = 0;
const maxPlayTime = 5; 
function loadVideo(index) {
    currentIndex = index;
    videoPlayer.src = videoSources[index];
    videoPlayer.load();
    videoPlayer.play();
    playPauseBtn.innerText = "⏸";
    resetProgressBars();
    highlightCurrentProgressLine();
}

loadVideo(currentIndex);

videoPlayer.addEventListener("ended", () => {
    currentIndex = (currentIndex + 1) % videoSources.length;
    loadVideo(currentIndex);
});

videoPlayer.addEventListener("timeupdate", () => {
   
    if (videoPlayer.currentTime >= maxPlayTime) {
        currentIndex = (currentIndex + 1) % videoSources.length;
        loadVideo(currentIndex);
        return;
    }

    const percent = (videoPlayer.currentTime / maxPlayTime) * 100;

    progressLines.forEach((line, index) => {
        const innerBar = line.querySelector("div");
        if (index === currentIndex && innerBar) {
            innerBar.style.width = `${percent}%`;
        } else if (innerBar) {
            innerBar.style.width = `0%`;
        }
    });
});

playPauseBtn.addEventListener("click", () => {
    if (videoPlayer.paused) {
        videoPlayer.play();
        playPauseBtn.innerText = "⏸";
    } else {
        videoPlayer.pause();
        playPauseBtn.innerText = "⏵";
    }
});

prevBtn.addEventListener("click", () => {
    currentIndex = (currentIndex - 1 + videoSources.length) % videoSources.length;
    loadVideo(currentIndex);
});

nextBtn.addEventListener("click", () => {
    currentIndex = (currentIndex + 1) % videoSources.length;
    loadVideo(currentIndex);
});

function resetProgressBars() {
    progressLines.forEach((line) => {
        line.innerHTML = `<div style="
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #ccc, #fff);
            transition: width 0.3s linear;
            border-radius: 2px;
        "></div>`;
    });
}

function highlightCurrentProgressLine() {
    progressLines.forEach((line, index) => {
        if (index === currentIndex) {
            line.classList.add("active");
        } else {
            line.classList.remove("active");
        }
    });
}

progressLines.forEach((line, index) => {
    line.style.cursor = "pointer";
    line.addEventListener("click", () => {
        loadVideo(index);
    });

   
    line.addEventListener("mouseenter", () => {
        line.style.opacity = "0.8";
    });

    line.addEventListener("mouseleave", () => {
        line.style.opacity = "1";
    });
});
