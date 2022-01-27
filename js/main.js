/* Color picker */

const xPickerOtions = document.querySelector('.color-picker-wrap_one').children,
      oPickerOtions = document.querySelector('.color-picker-wrap_two').children,
      playerOneTxt  = document.querySelector('.player-one'),
      playerTwoTxt  = document.querySelector('.player-two'),
      startButton   = document.querySelector('.btn-start');
      picker        = document.querySelector('.picker');
      game          = document.querySelector('.game');

let isPlayerOneTurn = true;
const colorPicked = "color-wrap-clicked";
"img/x-green.png"
const bgColorClasses = ["bg-red", "bg-green", "bg-blue", "bg-pink", "bg-orange"];
const colorClasses = ["color-red", "color-green", "color-blue", "color-pink", "color-orange"];
const xImages = ["img/x-red.png", "img/x-green.png", "img/x-blue.png", "img/x-pink.png", "img/x-orange.png"];
const oImages = ["img/o-red.png", "img/o-green.png", "img/o-blue.png", "img/o-pink.png", "img/o-orange.png"];
const xImage = "img/x.png";
const oImage = "img/o.png";
const blankImage = "img/blank.jpg";
// Game

const playerOneStatsBg  = document.querySelector('.player-stats-bg_one'),
      playerTwoStatsBg  = document.querySelector('.player-stats-bg_two'),
      playerOneTurnDOM  = document.querySelector('.player-score-turn_one'),
      playerTwoTurnDOM  = document.querySelector('.player-score-turn_two'),
      playerOneScoreDOM = document.querySelectorAll('.player-one-score'),
      playerOneBonusScoreDOM = document.querySelector('.player-one-bonus-score'),
      playerOneTotalScoreDOM = document.querySelector('.player-one-total-score'),
      playerTwoScoreDOM = document.querySelectorAll('.player-two-score'),
      playerTwoBonusScoreDOM = document.querySelector('.player-two-bonus-score'),
      playerTwoTotalScoreDOM = document.querySelector('.player-two-total-score'),
      gameboardTiles    = document.querySelector('.gameboard').children;

class PlayerPickSet {
    
    constructor(statsBg, turnShowDOM, scoreDOM, bonusScoreDOM, totalScoreDOM, myImage) {
        this.index = -1;
        this.isPicked = false;
        this.statsBg = statsBg;
        this.turnShowDOM = turnShowDOM;
        this.score = 0;
        this.scoreDOM = scoreDOM;
        this.bonusScoreDOM = bonusScoreDOM;
        this.totalScoreDOM = totalScoreDOM;
        this.myImage = myImage,
        this.myCorrectAnswers = [
            [false, false, false],
            [false, false, false],
            [false, false, false]
        ]
        this.bonusScore = 0;
        this.myXOScoreCur = 0;
    }
    resetForNextRound () {
        this.myCorrectAnswers = [
            [false, false, false],
            [false, false, false],
            [false, false, false]
        ]
        this.myXOScoreCur = 0;
    }
    XODiagScore () {
        let scoreCount = 0;
        if (this.myCorrectAnswers[0][0] == true &&
            this.myCorrectAnswers[1][1] == true &&
            this.myCorrectAnswers[2][2] == true) {
                scoreCount++;
            }
        if (this.myCorrectAnswers[0][2] == true &&
            this.myCorrectAnswers[1][1] == true &&
            this.myCorrectAnswers[2][0] == true) {
                scoreCount++;
            }
            this.myXOScoreCur += scoreCount;
    }
    XOColScore () {
        let scoreCount = 0;
        for (let i = 0; i < 3; i++){
            if (this.myCorrectAnswers[0][i] == true &&
                this.myCorrectAnswers[1][i] == true &&
                this.myCorrectAnswers[2][i] == true) {
                    scoreCount++;
                }
        }
        this.myXOScoreCur += scoreCount;
    }
    XORowScore () {
        let scoreCount = 0;
        for (let i = 0; i < 3; i++){
            if (this.myCorrectAnswers[i][0] == true &&
                this.myCorrectAnswers[i][1] == true &&
                this.myCorrectAnswers[i][2] == true) {
                    scoreCount++;
                }
        }
        this.myXOScoreCur += scoreCount;
    }
    XOScore () {
        this.myXOScoreCur = 0;
        this.XOColScore();
        this.XORowScore();
        this.XODiagScore();
        // this.addScore (this.myXOScoreCur);
        this.bonusScore += this.myXOScoreCur;
        this.bonusScoreDOM.innerHTML = this.bonusScore;
        this.totalScoreDOM.innerHTML = this.score + this.bonusScore;
    }
    changeIndex (newIndex) {
        this.index = newIndex;
        this.isPicked = true;
    }
    turnBgOn () {
        this.statsBg.classList.add(bgColorClasses[this.index]);
        this.turnShowDOM.classList.add('player-score-turn_on');
    }
    turnBgOff () {
        this.statsBg.classList.remove(bgColorClasses[this.index]);
        this.turnShowDOM.classList.remove('player-score-turn_on');
    }
    addScorePoint () {
        this.addScore(1);
    }
    addScore (scoreToAdd) {
        this.score = parseInt(this.score) + scoreToAdd;
        this.scoreDOM.forEach(score => {
            score.innerHTML = this.score;
        })
    }
    image () {
        return this.myImage;
    }
}

const changePick = (options, index, playerText) => {
    for(let i = 0; i < options.length; i++) {
        options[i].classList.remove(colorPicked);
    }
    options[index].classList.add(colorPicked);
    playerText.classList.remove("color-red", "color-green", "color-blue", "color-pink", "color-orange");
    playerText.classList.add(colorClasses[index]);
}

const addOptionListener = (options, playerPickSet, secPlayerPickSet, playerText) => {
    for (let i = 0; i < options.length; i++) {
        options[i].addEventListener('click', e => {
            if (secPlayerPickSet.index != i) {
                changePick(options, i, playerText);
                playerPickSet.changeIndex(i);
            }
        })
    }
}
let playerOne = new PlayerPickSet(playerOneStatsBg, playerOneTurnDOM, playerOneScoreDOM, playerOneBonusScoreDOM, playerOneTotalScoreDOM, xImage);
let playerTwo = new PlayerPickSet(playerTwoStatsBg, playerTwoTurnDOM, playerTwoScoreDOM, playerTwoBonusScoreDOM, playerTwoTotalScoreDOM, oImage);
let curPlayer = playerOne;
let otherPlayer = playerTwo;
addOptionListener(xPickerOtions, playerOne, playerTwo, playerOneTxt);
addOptionListener(oPickerOtions, playerTwo, playerOne, playerTwoTxt);

// Game

// Questions settings

/* All our options */

const modal = document.getElementById('wrapper-modal_quiz');
const roundModal = document.getElementById('wrapper-modal_round');
const roundNumberDOM = document.getElementById('round-number');
const answerModal = document.getElementById('wrapper-modal_answer');
const answerWrap = document.querySelector('.answer-wrap-in');
const answerTitle = document.getElementById('answer-title');
const answerLocation = document.getElementById('answer-location');
const answerLocationWrap = document.getElementById('answer-txt');
const roundTitle = document.getElementById('round-title');
const roundText = document.querySelector('.round-title');
const offlineBackToMenu = document.querySelector('.offline-back-wrap');

offlineBackToMenu.classList.add('hide');

answerModal.addEventListener('click', () => {
    answerModal.classList.remove('active');
    if (answeredCorrectly == 9) {
        finishRound();
    }
})

roundModal.addEventListener('click', () => {
    if ( curRound <= maxRound) {
        roundModal.classList.remove('active');
    }
})

let answeredCorrectly = 0;
let answers = [false, false, false, false, false, false, false, false, false];
let curRound = 1;
let maxRound = 2;

roundNumberDOM.innerHTML = curRound;
const resetBoard = () => {
    for (let i = 0; i < gameboardTiles.length; i++) {
        gameboardTiles[i].classList.remove(bgColorClasses[playerOne.index]);
        gameboardTiles[i].classList.remove(bgColorClasses[playerTwo.index]);
        gameboardTiles[i].children[0].children[0].children[0].src = blankImage;
    }
}

const roundMessagePrep = () => {
    roundNumberDOM.innerHTML = curRound;
    if (curRound == maxRound) {
        roundTitle.innerHTML = "Последний раунд";
    } else if (curRound > maxRound) {
        roundTitle.innerHTML = "Итог";
        roundText.innerHTML = "Итоговый счёт";
        offlineBackToMenu.classList.remove('hide');
    }

    roundModal.classList.add('active');
}
const prepareNextRound = () => {
    roundMessagePrep();
    answeredCorrectly = 0;
    answers = [false, false, false, false, false, false, false, false, false];
    playerOne.resetForNextRound();
    playerTwo.resetForNextRound();
    resetBoard();
}
const finishRound = () => {
    playerOne.XOScore();
    playerTwo.XOScore();
    curRound++;
    if (curRound < maxRound) {
        prepareNextRound();
    } else {
        // game over
        roundMessagePrep();
    }
}
const addTileListener = () => {
    for (let i = 0; i < gameboardTiles.length; i++) {
        gameboardTiles[i].addEventListener('click', e => {
            if(answers[i] == false)
            {
                loadQuestionWindow(i);
            }
        })
    }
}

const prepareGame = () => {
    playerOne.turnBgOn();
    picker.classList.add('hide');
    game.classList.remove('hide');
    roundMessagePrep(3000);
    addTileListener();
}


const quizWrap = document.querySelector('.quiz-wrap-out');

class RoundQuestionSet {

    constructor(questions) {
        this.questions = questions;
        this.maxTileNumber = 9;
        this.orderArray = [];
        this.randomizeQuestionOrder();
    }

    randomizeQuestionOrder () {
        let randomNumber = -1;
        let foundFree = false;
        let alreadyUsed = false;
    
        for(let i = 0; i < this.maxTileNumber; i++) {
            foundFree = false
            while(foundFree == false) {
                alreadyUsed = false;
                randomNumber = Math.floor(Math.random() * this.questions.length);
                this.orderArray.forEach(item => {
                    if(item == randomNumber) {
                        alreadyUsed = true;
                    }
                });

                if (alreadyUsed == false) {
                    this.orderArray.push(randomNumber);
                    foundFree = true;
                } else {
                    foundFree = false;
                }
            }
        }
    }

    ofIndex (index) {
        return this.questions[this.orderArray[index]];
    }
}

class QuestionManager {

    constructor(questions) {
        this.questions = questions;
        this.roundQuestionSet = [];
        this.createRounds();
    }

    createRounds () {
        let roundOneQuestions;
        this.questions.forEach(item => {
            roundOneQuestions = new RoundQuestionSet (item);
            this.roundQuestionSet.push(roundOneQuestions);
        })
    }

    getQuestion (roundNum, index) {
        return this.roundQuestionSet[roundNum-1].ofIndex(index);
    }
}

class DOMQuizManager {

    constructor (questions) {
        this.DOMQuestion = document.getElementById('question');
        this.DOMAnswers = document.querySelectorAll('.answer__item');
        this.questionManager = new QuestionManager(questions);
        this.quizWrap = document.querySelector('.quiz-wrap-out');
        this.btnAnswer = document.querySelector('.btn-answer');
        this.curRound = -1;
        this.curTile = -1;
        this.selectedTile = -1;
        this.setBtnAnswer ();
    }

    clearColors () {
        for(let i = 0; i < this.DOMAnswers.length; i++) {
            this.DOMAnswers[i].classList.remove(colorClasses[curPlayer.index]);
            this.DOMAnswers[i].children[0].classList.remove(colorClasses[curPlayer.index]);
            this.DOMAnswers[i].classList.remove(colorClasses[otherPlayer.index]);
            this.DOMAnswers[i].children[0].classList.remove(colorClasses[otherPlayer.index]);
        }
    }

    clearBGColors () {
        for(let i = 0; i < this.DOMAnswers.length; i++) {
            this.DOMAnswers[i].classList.remove(bgColorClasses[curPlayer.index]);
            this.DOMAnswers[i].children[0].classList.remove(colorClasses[curPlayer.index]);
            this.DOMAnswers[i].classList.remove(bgColorClasses[otherPlayer.index]);
            this.DOMAnswers[i].children[0].classList.remove("color-white");
            this.DOMAnswers[i].children[0].classList.remove(colorClasses[otherPlayer.index]);
        }
    }

    setNextQuestion (tileIndex) {
        this.selectedTile = -1;
        this.curRound = curRound;
        this.curTile = tileIndex;
        this.DOMQuestion.innerHTML = this.questionManager.getQuestion(this.curRound, this.curTile).question;
        for(let i = 0; i < 4; i++) {
            this.DOMAnswers[i].children[0].innerHTML = this.questionManager.getQuestion(this.curRound, this.curTile).options[i];

            this.DOMAnswers[i].addEventListener('click', e => {
                this.selectedTile = i;
                
                this.clearBGColors();
                e.currentTarget.classList.add(bgColorClasses[curPlayer.index]);
                e.currentTarget.children[0].classList.add("color-white");
            })
        }

        this.quizWrap.classList.remove(bgColorClasses[otherPlayer.index]);
        this.quizWrap.classList.add(bgColorClasses[curPlayer.index]);

        this.clearColors();
        for(let i = 0; i < this.DOMAnswers.length; i++)
        {
            this.DOMAnswers[i].classList.add(colorClasses[curPlayer.index]);
            this.DOMAnswers[i].children[0].classList.add(colorClasses[curPlayer.index]);
        }
    }

    setBtnAnswer () {
        let tempPlayer;
        this.btnAnswer.addEventListener('click', () => {
            if (this.selectedTile != -1) {
                let isCorrect = false;
                answerTitle.innerHTML = "Не верно";
                answerWrap.classList.remove('message-wrap-in-correct');
                answerWrap.classList.add('message-wrap-in-wrong');
                answerLocationWrap.classList.add('hide');
                answerLocation.innerHTML = this.questionManager.getQuestion(this.curRound, this.curTile).location;
                if(this.questionManager.getQuestion(this.curRound, this.curTile).options[this.selectedTile] == 
                   this.questionManager.getQuestion(this.curRound, this.curTile).rightAnswer) {
                    isCorrect = true;
                   }
                if(isCorrect) {
                    let row, col;
                    answeredCorrectly++;
                    answers[this.curTile] = true;
                    
                    answerLocationWrap.classList.remove('hide');
                    answerTitle.innerHTML = "Верно";
                    answerWrap.classList.remove('message-wrap-in-wrong');
                    answerWrap.classList.add('message-wrap-in-correct');
                    curPlayer.addScorePoint();
                    row = Math.floor(this.curTile / 3);
                    col = Math.floor(this.curTile % 3);
                    curPlayer.myCorrectAnswers[row][col] = true;
                    gameboardTiles[this.curTile].classList.add(bgColorClasses[curPlayer.index]);
                    gameboardTiles[this.curTile].children[0].children[0].children[0].src = curPlayer.image();
                }

                answerModal.classList.add('active');
                this.clearBGColors(curPlayer);
                this.clearColors(curPlayer);
                otherPlayer.turnBgOn();
                curPlayer.turnBgOff();
                tempPlayer = curPlayer;
                curPlayer = otherPlayer;
                otherPlayer = tempPlayer;
                modal.classList.remove('active');
            }
        })
    }
}

let singleQuestion = [];
let questionsTotal = [];
let questionsRound = [];
let DBQuestions = [];
let questionId = '';
let numPrefix = '№';

let dataBaseOrderArray = [];
const randomizeDataBaseQuestionOrder = () => {
    let foundFree = false;
    let foundMatch = false;
    let newIndex = 0;
    for (let i = 0; i < DBQuestions.length; i++) {
        foundFree = false;
        while(!foundFree) {
            newIndex = Math.floor(Math.random() * DBQuestions.length);

            foundMatch = false;
            for (let j = 0; j < dataBaseOrderArray.length; j++) {
                if(dataBaseOrderArray[j] == newIndex) {
                    foundMatch = true;
                }
            }

            if(!foundMatch) {
                foundFree = true;
                dataBaseOrderArray.push(newIndex);
            }
        }
    }
}
// Math.floor(Math.random() * 10);

const createQuestion = (index) => {
    questionId = DBQuestions[dataBaseOrderArray[index]]["id"];
    questionIdPrefix = numPrefix.concat(questionId);
    singleQuestion = {
        question: questionIdPrefix.concat(" ", DBQuestions[dataBaseOrderArray[index]]["question"]),
        options: [
            DBQuestions[dataBaseOrderArray[index]]["option1"],
            DBQuestions[dataBaseOrderArray[index]]["option2"],
            DBQuestions[dataBaseOrderArray[index]]["option3"],
            DBQuestions[dataBaseOrderArray[index]]["option4"],
        ],
        rightAnswer: DBQuestions[dataBaseOrderArray[index]]["answer"],
        location: DBQuestions[dataBaseOrderArray[index]]["location"]
    };
}

const arrangeQuestions = () => {
    let questionLimitPerRound = 0;
    let index = 0;

    singleQuestion = [];
    questionsTotal = [];
    maxRound = parseInt(DBQuestions.length / 9);
    
    questionLimitPerRound = parseInt(DBQuestions.length / maxRound);

    for(let j = 0; j < maxRound; j++){
        questionsRound = [];
        for(let i = 0; i < questionLimitPerRound; i++){
            index = i + questionLimitPerRound * j;

            createQuestion(index);

            questionsRound.push(singleQuestion);
        }

        if (index + 2 == DBQuestions.length) {
            createQuestion(index + 1);
            questionsRound.push(singleQuestion);
        }

        questionsTotal.push(questionsRound);
    }
}

const loadQuestionWindow = (tileIndex) => {
    // Modal Window With Question
    modal.classList.add('active');
    aDOMQuizManager.setNextQuestion(tileIndex);
}

let aDOMQuizManager;

const xhttp = new XMLHttpRequest();
xhttp.onload = function() {
    DBQuestions = JSON.parse(this.responseText);
    randomizeDataBaseQuestionOrder();
    arrangeQuestions();

    aDOMQuizManager = new DOMQuizManager(questionsTotal);

    startButton.addEventListener('click', () => {
        if(playerOne.isPicked && playerTwo.isPicked){
            prepareGame();
        }
    })
}
xhttp.open("GET", "questions.php");
xhttp.send();

let btnBeginGame = document.querySelector('.btn-begin-game');
let headerDOM = document.querySelector('.header');
let beforeGameDOM = document.querySelector('.before-game');

btnBeginGame.addEventListener('click', () => {
    beforeGameDOM.classList.add('hide');
    headerDOM.classList.remove('hide');
})


let mainMenuButtons = document.querySelector('.main-menu-buttons');

// XO Game

