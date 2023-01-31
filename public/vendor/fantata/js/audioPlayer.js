let playIconContainers = document.getElementsByClassName('play-icon');
let audioPlayerContainers = document.getElementsByClassName(
    "audio-player-container"
);
let seekSliders = document.getElementsByClassName("seek-slider");
let volumeSliders = document.getElementsByClassName("volume-slider");
let muteIconContainers = document.getElementsByClassName("mute-icon");

let playState = 'play';
let muteState = 'unmute';

let currentIndex;


const displayBufferedAmount = () => {
    const bufferedAmount = Math.floor(
        audios[currentIndex].buffered.end(
            audios[currentIndex].buffered.length - 1
        )
    );

    audios[currentIndex].style.setProperty(
        "--buffered-width",
        `${(bufferedAmount / seekSliders[currentIndex].max) * 100}%`
    );
};


playIconContainers = Array.from(playIconContainers);

playIconContainers.map( (cur, i, arr) => {

    cur.style.backgroundImage = "url(/vendor/fantata/img/play.png)";

    cur.addEventListener("click", () => {

        if (playState === "play") {

            audios[i].play();
            cur.style.backgroundImage = "url(/vendor/fantata/img/pause.png)";
            currentIndex = i;
            requestAnimationFrame(whilePlaying);
            playState = "pause";

        } else {

            audios[i].pause();
            cur.style.backgroundImage = "url(/vendor/fantata/img/play.png)";
            cancelAnimationFrame(raf);
            playState = "play";

        }

    });

});

muteIconContainers = Array.from(muteIconContainers);
muteIconContainers.map((cur, i, arr) => {

    cur.style.backgroundImage = "url(/vendor/fantata/img/unmute.png)";

    cur.addEventListener("click", () => {

        if (muteState === "unmute") {

            cur.style.backgroundImage = "url(/vendor/fantata/img/mute.png)";
            audios[i].muted = true;
            muteState = "mute";

        } else {

            cur.style.backgroundImage = "url(/vendor/fantata/img/unmute.png)";
            audios[i].muted = false;
            muteState = "unmute";

        }

    });

});

audioPlayerContainers = Array.from(audioPlayerContainers);
const showRangeProgress = (rangeInput, i) => {

    if (rangeInput === seekSliders[i]) {

        audioPlayerContainers[i].style.setProperty('--seek-before-width', rangeInput.value / rangeInput.max * 100 + '%');

    } else {

        audioPlayerContainers[i].style.setProperty('--volume-before-width', rangeInput.value / rangeInput.max * 100 + '%');

    }

}

seekSliders = Array.from(seekSliders);
seekSliders.map((cur, i, arr) => {

    cur.addEventListener("input", (e) => {
        showRangeProgress(e.target, i);
    });

});

volumeSliders = Array.from(volumeSliders);
volumeSliders.map((cur, i, arr) => {

    cur.addEventListener("input", (e) => {
        showRangeProgress(e.target, i);
    });

});

let audios = document.getElementsByClassName("audio-widget");
let durationContainers = document.getElementsByClassName("duration");
let currentTimeContainers = document.getElementsByClassName("current-time");

let raf = null;

const calculateTime = (secs) => {
    const minutes = Math.floor(secs / 60);
    const seconds = Math.floor(secs % 60);
    const returnedSeconds = seconds < 10 ? `0${seconds}` : `${seconds}`;
    return `${minutes}:${returnedSeconds}`;
}


durationContainers = Array.from(durationContainers);

const displayDuration = () => {

    durationContainers[currentIndex].textContent = calculateTime(audios[currentIndex].duration);

};


seekSliders = Array.from(seekSliders);

let setSliderMax;

seekSliders.map((cur, i, arr) => {

    setSliderMax = () => {

        cur.max = Math.floor(audios[i].duration);

    };

});



const whilePlaying = () => {

    let cur = seekSliders[currentIndex];

    cur.value = Math.floor(audios[currentIndex].currentTime);

    currentTimeContainers[currentIndex].textContent = calculateTime(cur.value);

    audioPlayerContainers[currentIndex].style.setProperty(
        "--seek-before-width",
        `${(cur.value / cur.max) * 100}%`
    );

    raf = requestAnimationFrame(whilePlaying);

};


seekSliders.map((cur, i, arr) => {

    cur.addEventListener("input", () => {

        currentTimeContainers[i].textContent = calculateTime(cur.value);

        if (!audios[i].paused) {

            cancelAnimationFrame(raf);

        }

    });

    cur.addEventListener("change", () => {

        audios[i].currentTime = cur.value;

        if (!audios[i].paused) {

            currentIndex = i;
            requestAnimationFrame(whilePlaying);

        }
    });

});


audios = Array.from(audios);

audios.map( (cur, i, arr) => {

    currentIndex = i;

    if (cur.readyState > 0) {

        displayDuration();
        setSliderMax();
        displayBufferedAmount();

    } else {

        cur.addEventListener("loadedmetadata", () => {

            displayDuration();
            setSliderMax();
            displayBufferedAmount();

        });

    }

});


volumeSliders = Array.from(volumeSliders);

volumeSliders.map((cur, i, arr) => {

    cur.addEventListener("input", (e) => {

        const value = e.target.value;

        audios[i].volume = value / 100;

    });

});
