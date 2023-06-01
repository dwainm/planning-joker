import { Link } from '@inertiajs/react';
import {ActionList, ActionMenu} from '@primer/react'

export default function Layout({ children }) {
  return (
        <main>
            <header className='Header js-details-container Details px-3 px-md-4 px-lg-5 flex-wrap flex-md-nowrap'>
                <div className="Header-item mt-n1 mb-n1  d-none d-md-flex">
                    <Link href="/">
                        <img
                            src="http://127.0.0.1:8000/images/planning-joker-jester-hat-by-flaticon-user-alfanz.png"
                            alt="Temp planning poker logo"
                            width="50px"
                            className="border circle cursor-all-scroll mx-auto scale-100 hover:scale-125 ease-in duration-200"
                        />
                    </Link>
                </div>
                <div className="Header-item Header-item--full">
                    <Link className='Header-link' href="/"> Dashboard </Link>
                </div>

                <div className="Header-item Header-item--full">
                    <Link
                        className='Header-link'
                        method='post'
                        as='button'
                        href={route('logout')}>
                        Log out
                    </Link>
                </div>
                <ActionMenu>
                    <ActionMenu.Button>Profile</ActionMenu.Button>

                    <ActionMenu.Overlay>
                        <ActionList>
                            <ActionList.Item>
                                <div className="Header-item Header-item--full">
                                    <Link className='Header-link' href="route('profile.edit') ">
                                        Profile Edit
                                    </Link>
                                </div>
                            </ActionList.Item>
                            <ActionList.Item>
                                <Link
                                    className='Header-link'
                                    method='post'
                                    as='button'
                                    href={route('logout')}>
                                    Log out
                                </Link>
                            </ActionList.Item>
                        </ActionList>
                    </ActionMenu.Overlay>
                </ActionMenu>
            </header>
            <article>{children}</article>
        </main>
  )
}
