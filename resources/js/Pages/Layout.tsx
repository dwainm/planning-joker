import { Link } from '@inertiajs/react'

export default function Layout({ children }) {
  return (
    <main>
      <header className='Header js-details-container Details px-3 px-md-4 px-lg-5 flex-wrap flex-md-nowrap'>
        <div className="Header-item mt-n1 mb-n1  d-none d-md-flex">
            <Link href="$route('/dashboard')">
                <img
                    src="http://127.0.0.1:8000/images/planning-joker-jester-hat-by-flaticon-user-alfanz.png"
                    alt="Temp planning poker logo"
                    width="50px"
                    className="border circle cursor-all-scroll mx-auto scale-100 hover:scale-125 ease-in duration-200"
                    />
            </Link>
        </div>
                  <div className="Header-item Header-item--full">
                    <Link className='Header-link' href="$route('/dashboard')"> Dashboard </Link>
                    </div>
      </header>
      <article>{children}</article>
    </main>
  )
}
