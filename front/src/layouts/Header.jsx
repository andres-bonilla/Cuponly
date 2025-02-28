import { useEffect, useState } from 'react'
import { Dash } from '../components/Dash'
import UserLogo from "../assets/user.svg?react";
import { useNotifier } from '../context/NotifierContext';

export const Header = () => {
  const [openDash, setOpenDash] = useState(false)

  const { event, trigger } = useNotifier();
  const acceptedEvents = ["use-coupon-without-login"]

  useEffect(()=>{
    if (acceptedEvents.includes(event)){
      setOpenDash(true)
      trigger("");
    }
  },[event])

  return (
    <header id="head">
      <a href="/" className='no-link-style'>
        <h1 id='text-logo' className='grow'>Cupon<span className='text-with-color'>ly</span></h1>
      </a>
      <button className='user-button' onClick={() => setOpenDash(prev => !prev)}>
        <UserLogo id="user-logo"/>
      </button>

      <Dash openDash={openDash}/>
    </header>
  );
}