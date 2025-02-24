import React from "react";
import { useRedeemCoupon } from "../../hooks/useRedeemCoupon";
export const Strip = ({coupon, countdown, showMessage}) => {
  const {isLoading, redeemCoupon} = useRedeemCoupon();

  const handleClick = ()=> {
    redeemCoupon(coupon.id, showMessage);
  }

  return (
    <li className="strip">
      <div className="strip-info">
        <span className="strip-brand">{coupon.brand}</span>
        <time className="redeem-timer">{countdown}</time>
      </div>
    {coupon.pivot["usage_status"] !== "used" 
      ? <button disabled={true} className="btn disable-btn strip-btn">
          {coupon.pivot["usage_status"] === "redeemed" ? "Canjeado" : "Perdiste"}<br/><span className="discount">{coupon.discount}% OFF</span></button>
      : <button onClick={handleClick} className="btn green-btn">
        {isLoading 
          ? <span className='loading'>...</span>
          : (<>Canjear<br/><span className="discount">{coupon.discount}% OFF</span></>)
        }
      </button>
    }
</li>)
}