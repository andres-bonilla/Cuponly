import React from 'react';
import { useAssignCoupon } from '../../hooks/useAssignCoupon';
import { useNotifier } from '../../context/NotifierContext';
import { useAuth } from '../../context/AuthContext';

const brandLogos = {
  'Adidas': 'adidas',
  'Asics': 'asics',
  'Fila': 'fila',
  'Hummel': 'hummel',
  'Joma': 'joma',
  'Kelme': 'kelme',
  'Le Coq': 'lecoq',
  'Mizuno': 'mizuno',
  'New Balance': 'nb',
  'Nike': 'nike',
  'Olympikus': 'olympikus',
  'Puma': 'puma',
  'Reebok': 'reebok',
  'Under Armour': 'ua',
  'Umbro': 'umbro',
};

export const Card = ({ coupon, countdown, showMessage }) => {
  const {isLoading, assignCoupon} = useAssignCoupon();


  const { trigger } = useNotifier();
  const { session } = useAuth();

  const handleClick = ()=> {
    console.log(`./assets/logos/${brandLogos[coupon.brand]}.svg`)
    if (session) assignCoupon(coupon.id, showMessage);
    else trigger("use-coupon-without-login");
  }

  return (
    <li className={`card`} >
      <div className='coupon'>
        <div className="brand">
          <img src={`./src/assets/logos/${logos[coupon.brand]}.svg`} alt={coupon.brand} />
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