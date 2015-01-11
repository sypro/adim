        <img src="/images/error-img.png" title="error" />
        <p><span><label>O</label>hh.....</span>You Requested the page that is no longer There.</p>
        <p><span><label><?=$code?></label> </span><?=$message?></p>

<style>


    .content p{
        margin: 18px 0px 45px 0px;
    }
    .content p{
        font-family: "Century Gothic";
        font-size:2em;
        color:#666;
        text-align:center;
    }
    .content p span,.logo h1 a{
        color:#e54040;
    }
    .content{
        text-align:center;
        padding:115px 0px 0px 0px;
    }

        /*------responive-design--------*/
    @media screen and (max-width: 1366px)	{
        .content {
            padding: 58px 0px 0px 0px;
        }
    }
    @media screen and (max-width:1280px)	{
        .content {
            padding: 58px 0px 0px 0px;
        }
    }
    @media screen and (max-width:1024px)	{
        .content {
            padding: 58px 0px 0px 0px;
        }
        .content p {
            font-size: 1.5em;
        }

    }
    @media screen and (max-width:640px)	{
        .content {
            padding: 58px 0px 0px 0px;
        }
        .content p {
            font-size: 1.3em;
        }

    }
    @media screen and (max-width:460px)	{
        .content {
            padding:20px 0px 0px 0px;
            margin:0px 12px;
        }
        .content p {
            font-size:0.9em;
        }

    }
    @media screen and (max-width:320px)	{
        .content {
            padding:30px 0px 0px 0px;
            margin:0px 12px;
        }
        .content a {
            padding:10px 15px;
            font-size:0.8em;
        }
        .content p {
            margin: 18px 0px 22px 0px;
        }
    }
</style>