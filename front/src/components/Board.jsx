import React, { useState } from "react";
import { useAuth } from "../context/AuthContext";
import { Strip } from "./commons/Strip";
import { useCountdowns } from "../hooks/useCountdowns";
import { calcRedeemExpiration } from "./helpers/calcRedeemExpiration";
import { useGetUserCoupons } from "../hooks/useGetUserCoupons";
import { useInvalidNotifier } from "../hooks/useInvalidNotifier";
import { Modal } from "./commons/Modal";
import { useLogOut } from "../hooks/useLogOut";


export const Board = () => {
  const [modalInfo, setModalInfo] = useState(null);
  
  const openModal = (couponInfo) => setModalInfo({title: couponInfo.pivot.code, message: `Haz canjeado tu ${couponInfo.discount}% OFF en ${couponInfo.brand} con exito.`});

  const closeModal = () => setModalInfo(null);

  const { userCoupons } = useGetUserCoupons();
  const { countdowns } = useCountdowns(userCoupons.map(calcRedeemExpiration));
  useInvalidNotifier(countdowns);
  const {isLoading, logOutUser} = useLogOut();

  const { session } = useAuth();

  return <div className="board">
    <h2 className='dash-title'>{session && session.user ? session.user.name : 'Dash'}</h2>
    <button className='btn btn-cancel board-btn' onClick={logOutUser}>
      {isLoading 
        ? <span >...</span>
        : (<>Cerrar Sesión</>)
      }
    </button>
    <div className="coupon-list">
      <h2 className='dash-title'>Mis cupones</h2>
      { userCoupons.length 
      ? <ul>
          {userCoupons.map((coupon, index) => {
            return <Strip 
              key={coupon.id * session.user.id} 
              coupon={coupon} 
              countdown={countdowns[index]}
              showMessage={() => openModal(coupon)}
            />
          })}
        </ul> 
      : <p>No tienes cupones</p>}
    </div>
    {modalInfo && <Modal message={modalInfo.message} onConfirm={closeModal} title={modalInfo.title}/>}
  </div>
}