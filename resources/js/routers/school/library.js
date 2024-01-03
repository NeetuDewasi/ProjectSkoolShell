import LibraryBookCategory from "../../components/pages/library/categories/LibraryBookCategory.vue";
import LibraryBookCategoryCreate from "../../components/pages/library/categories/LibraryBookCategoryCreate.vue";
import LibraryBookShelf from "../../components/pages/library/shelves/LibraryBookShelf.vue";
import LibraryBookShelfCreate from "../../components/pages/library/shelves/LibraryBookShelfCreate.vue";
import LibraryBook from "../../components/pages/library/books/LibraryBook.vue";
import LibraryBookCreate from "../../components/pages/library/books/LibraryBookCreate.vue";
import IssueReturn from "../../components/pages/library/books/IssueReturn.vue";
import ViewIssuedBook from "../../components/pages/library/books/ViewIssuedBook.vue";
import AddStudent from "../../components/pages/library/AddStudent.vue";
import AddLibraryStudent from "../../components/pages/library/add_student/AddLibraryStudent.vue";
import AddStaffMember from "../../components/pages/library/AddStaffMember.vue";

export default [
    {
        name: "school.library.categories",
        path: "/school/library/categories",
        component: LibraryBookCategory,
        props: true,
    },
    {
        name: "school.library.categories.create",
        path: "/school/library/categories/create",
        component: LibraryBookCategoryCreate,
        props: true,
    },
    {
        name: "school.library.shelves",
        path: "/school/library/shelves",
        component: LibraryBookShelf,
        props: true,
    },
    {
        name: "school.library.shelves.create",
        path: "/school/library/shelves/create",
        component: LibraryBookShelfCreate,
        props: true,
    },
    {
        name: "school.library.books",
        path: "/school/library/books",
        component: LibraryBook,
        props: true,
    },
    {
        name: "school.library.books.create",
        path: "/school/library/books/create",
        component: LibraryBookCreate,
        props: true,
    },
    {
        name: "school.library.books.issue_return",
        path: "/school/library/books/issue_return",
        component: IssueReturn,
        props: true,
    },
    {
        name: "school.library.books.view_issued_book",
        path: "/school/library/books/view_issued_book",
        component: ViewIssuedBook,
        props: true,
    },
    {
        name: "school.library.add_student",
        path: "/school/library/add_student",
        component: AddStudent,
        props: true,
    },
    {
        name: "school.library.add_library_student",
        path: "/school/library/add_library_student",
        component: AddLibraryStudent,
        props: true,
    },
    {
        name: "school.library.add_staff",
        path: "/school/library/add_staff",
        component: AddStaffMember,
        props: true,
    },
];

