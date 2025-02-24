import { Auth } from './Auth'
import { Board } from './Board';
import { useAuth } from '../context/AuthContext';

export const Dash = ({openDash}) => {
  const { session } = useAuth();

  return <div className={`dash-container ${openDash ? "active" : ""}`}>
    <div className="dash-content" >
      {session ? <Board/> : <Auth/>}
    </div>
  </div>
}