import React from 'react';
import { useAssignCoupon } from '../../hooks/useAssignCoupon';
import { useNotifier } from '../../context/NotifierContext';
import { useAuth } from '../../context/AuthContext';

export const Card = ({ coupon, countdown, showMessage }) => {
  const {isLoading, assignCoupon} = useAssignCoupon();

  const { trigger } = useNotifier();
    const { session } = useAuth();

  const handleClick = ()=> {
    if (session) assignCoupon(coupon.id, showMessage);
    else trigger("use-coupon-without-login");
  }

  return (
    <li className={`card`} >
      <div className='coupon'>
        <div className="brand">
          <h3>{coupon.brand}</h3>
        </div>
      
        <button 
          className={`btn ${countdown === "Expirado" ? "disable-btn" : "green-btn"}`} 
          onClick={handleClick}
          >{isLoading 
            ? <span className='loading'>...</span>
            : (<>Obtener<br/><span className="discount">{coupon.discount}% OFF</span></>)}
        </button>
      </div>
      
      <time className="countdown">{countdown}</time>
    </li>);
}