import { useCountdowns } from "../hooks/useCountdowns";
import { Card } from "./commons/Card";
import { useExpiredNotifier } from "../hooks/useExpiredNotifier";
import { useGetValidCoupons } from "../hooks/useGetValidCoupons";
import { useState } from "react";
import { Modal } from "./commons/Modal";

export const Grid = () => {
  const [modalMessage, setModalMessage] = useState("");
  
  const openModal = (couponInfo) => setModalMessage(`Haz obtenido ${couponInfo.discount}% OFF en ${couponInfo.brand}. Tienes ${couponInfo["usage_period"]} horas para usarlo.`);

  const closeModal = () => setModalMessage(""); 

  const { coupons } = useGetValidCoupons();
  const { countdowns } = useCountdowns(coupons.map(item => item.expiration));
  useExpiredNotifier(countdowns);

  return <main>
    <ul className="grid">
      {coupons.length 
      ? coupons.map((coupon, index)=>{
        return <Card 
          key={coupon.id} 
          coupon={coupon} 
          countdown={countdowns[index]}
          showMessage={() => openModal(coupon)}/>
      }) 
      : <p>No hay cupones disponibles</p>}
    </ul>
    {modalMessage && <Modal onConfirm={closeModal} message={modalMessage}/>}
  </main>
}
