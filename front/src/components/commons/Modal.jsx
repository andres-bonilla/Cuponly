import React from 'react';

export const Modal = ({ 
  message, 
  onConfirm, 
  onCancel = null,
  title = "",
  buttonText = "Aceptar",
  cancelText = "Cancelar"
}) => {
  return (
    <div className={`modal-overlay ${message ? "show-modal" : ""}`}>
      <div className={`modal-content ${message ? "show-modal" : ""}`}>
        {title && <h2 className='modal-title'>{title}</h2>}
        <p className="modal-message">{message}</p>
        <div className="modal-buttons">
          {onCancel && (
            <button className="btn btn-cancel" onClick={onCancel}>
              {cancelText}
            </button>
          )}
          <button className="btn" onClick={onConfirm}>
            {buttonText}
          </button>
        </div>
      </div>
    </div>
  );
};