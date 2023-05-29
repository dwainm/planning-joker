import Layout from './Layout'
import LoginForm from './LoginForm'
import { router } from '@inertiajs/react'
import {Button} from '@primer/react'

export default function Login(...args) {
    console.log('hi function');

    const handleSubmit = (e) => {
        console.log('submit function');
        e.preventDefault();
        router.get('/auth/github')
    }

  return (
    // <x-auth-session-status class="mb-4" :status="session('status')" />
    // @Todo: session to be displayed

          <div className="mt-12">
          <div className="col-6 p-2 mt mx-auto">

<div className="mx-auto col-6">
  <div className="Box">
    <div className="Box-row">
      <h3 className="m-0">Welcome to Planning Poker! </h3>
    </div>
    <div className="Box-row">
      <p className="mb-0 color-fg-muted">
        The exclusive planning poker tool for Githhub Projects.
      </p>
    </div>
    <div className="Box-row">
    <form onSubmit={handleSubmit}>
           <Button type="submit" className='mx-auto btn btn-primary'>Log in with GitHub</Button>
           </form>
    </div>
  </div>
</div>
          </div>
</div>


		// <a href="{}">
            // <x-primary-button class=" flex rounded px-6
		// 	py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg">
            // </x-primary-button>
		// </a>

  )
}

