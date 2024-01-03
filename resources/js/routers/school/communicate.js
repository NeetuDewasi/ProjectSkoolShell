import EmailSMSLog from "../../components/pages/communicate/emailSMS/EmailSMSLog.vue";
import NoticeBoard from "../../components/pages/communicate/notice_board/NoticeBoard.vue";
import NoticeViewPage from "../../components/pages/communicate/notice_board/NoticeViewPage.vue";
import NoticeAdd from "../../components/pages/communicate/notice_board/NoticeAdd.vue";
import SendEmailLog from "../../components/pages/communicate/emailSMS/SendEmailLog.vue";
import EmailSMSView from "../../components/pages/communicate/emailSMS/EmailSMSView.vue";
import SendMessage from "../../components/pages/communicate/SendMessage.vue";

export default [
    {
        name: "school.communicate.email_log",
        path: "/school/communicate/email_log",
        component: EmailSMSLog,
        props: true,
    },

    {
        name: "school.communicate.notice",
        path: "/school/communicate/notice",
        component: NoticeBoard,
        props: true,
    },
    {
        name: "school.communicate.notice_view",
        path: "/school/communicate/notice_view/:id",
        component: NoticeViewPage,
        props: true,
    },
    {
        name: "school.communicate.notice_add",
        path: "/school/communicate/notice_add",
        component: NoticeAdd,
        props: true,
    },
    {
        name: "school.communicate.notice_add",
        path: "/school/communicate/notice_add/:noticeBoard_id",
        component: NoticeAdd,
        props: true,
    },
    {
        name: "school.communicate.email",
        path: "/school/communicate/email/:message_id",
        component: SendEmailLog,
        props: true,
    },
    {
        name: "school.communicate.send_email",
        path: "/school/communicate/send_email",
        component: SendEmailLog,
        props: true,
    },
    {
        name: "school.communicate.email_view",
        path: "/school/communicate/email_view/:message_id",
        component: EmailSMSView,
        props: true,
    },

    // {
    //     name: "school.communicate.message",
    //     path: "/school/communicate/message",
    //     component: SendMessage,
    //     props: true,
    // },
];
