import React, { createContext, useState, useContext } from 'react';

const NotifierContext = createContext();

export const NotifierProvider = ({ children }) => {
  const [event, setEvent] = useState("init");

  const trigger = (newEvent) => {
    setEvent(newEvent);
  };

  return (
    <NotifierContext.Provider value={{ event, trigger }}>
      {children}
    </NotifierContext.Provider>
  );
};

export const useNotifier = () => {
  return useContext(NotifierContext);
};
