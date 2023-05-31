import Layout from './Layout'
import { router } from '@inertiajs/react'
import {Button} from '@primer/react'
import {MarkGithubIcon} from '@primer/octicons-react'

export default function LoginForm(...args) {
    console.log('hi function');

    const handleSubmit = (e) => {
        console.log('submit function');
        e.preventDefault();
        router.get('/auth/github')
    }

    return (
        // @Todo: session to be displayed
        <div className="Box col-3 p-2 mt-12 mx-auto">
            <div className="Box-row border-0">
                <h3 className="m-0">Welcome to Planning Poker! </h3>
            </div>
            <div className="Box-row">
                <p className="mb-0 color-fg-muted">
                    The exclusive planning poker tool for Githhub Projects.
                </p>
            </div>
            <div className="Box-row">
                <form onSubmit={handleSubmit}>
                    <Button
                        onClick={handleSubmit}
                        leadingIcon={MarkGithubIcon}
                        className='mx-auto btn color-fg-on-emphasis color-bg-emphasis'>
                        GitHub Login
                    </Button>
                </form>
            </div>
        </div>





        // <a href="{}">
        // <x-primary-button class=" flex rounded px-6
        // 	py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:shadow-lg focus:shadow-lg focus:outline-none focus:ring-0 active:shadow-lg">
        // </x-primary-button>
        // </a>

    )
}

