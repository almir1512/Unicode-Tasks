import React from "react"
import { CircularProgressbar, buildStyles} from 'react-circular-progressbar'
import PlayButton from "./PlayButton"
import PauseButton from "./PauseButton"
import SettingsButton from "./SettingsButton"
import {useState , useEffect, useRef} from "react"

const red = '#f54e4e';
const green='#4aec8c';

export default function Timer(){
    const [isPaused,setisPaused] = useState(false);
    const [mode,setMode] = useState('work') //work/break/pause
    const [secondsLeft, setSecondsLeft]= useState(0);
    
    const secondsLeftRef = useRef(secondsLeft);
    const isPausedRef = useRef(isPaused);
    const modeRef= useRef(mode);
        
    function initTimer (){
        setSecondsLeft(25*60);
    }
    function switchMode(){
        const nextMode = modeRef.current === 'work'? 'break' : 'work';
        const nextSeconds = nextMode ==='work' ? 25*60:5*60
        setMode(nextMode);
        modeRef.current=nextMode;
        
        setSecondsLeft(nextSeconds);
        secondsLeftRef.current = nextSeconds;
    }
    function tick (){
        secondsLeftRef.current--;
        setSecondsLeft(secondsLeftRef.current);
    }
    useEffect (()=>{
      initTimer(); 
      
      const interval = setInterval(()=>{
          if(isPausedRef.current){
              return;
          }
          if(secondsLeftRef.current===0){
              return switchMode();
          }
          tick();
      },1000)
      return clearInterval(interval);
    },[]);
    
    const totalSeconds 
    const percentage = Math.round(secondsLeft/totalSeconds)
    return (
        <div>
       <CircularProgressbar value={60} text={`60%`} styles= {buildStyles({
           textColor:'#fff',
           pathColor:red,
           tailColor:'rgba(255,255,255,.2)',
                    
       })} />
        <div>
        {isPaused ? <PlayButton /> : <PauseButton />}        
        </div>
        <div>
        <SettingsButton />
        </div>
        </div>
    );
}
