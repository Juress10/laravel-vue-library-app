<template>
    <div class="">
        <v-app>
            <div class="row justify-content-center auto-height-container">
                <v-data-table
                    :headers="headers"
                    :items="items"
                    class="elevation-1 table-container"
                >
                    <template v-slot:top>
                        <v-toolbar flat color="white">
                            <v-spacer></v-spacer>
                            <v-dialog v-model="dialog" max-width="500px">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                        color="#94d0bb"
                                        dark
                                        class="mb-2"
                                        v-bind="attrs"
                                        v-on="on"
                                    >New Book</v-btn>
                                </template>
                                <v-card>
                                    <v-card-title>
                                        <span class="headline">{{ formTitle }}</span>
                                    </v-card-title>

                                    <v-card-text>
                                        <v-container>
                                            <v-row>
                                                <v-col cols="12" sm="6" md="4">
                                                    <v-text-field color="rgb(148, 208, 187)" v-model="editedItem.title" label="Title"></v-text-field>
                                                </v-col>
                                                <v-col cols="12" sm="6" md="4">
                                                    <v-switch color="rgb(148, 208, 187)" v-model="editedItem.is_borrowed" class="ma-2" label="Is borrowed"></v-switch>
                                                </v-col>
                                                <v-col cols="6">
                                                    <v-select
                                                        v-model="editedItem.author"
                                                        :hint="`${editedItem.author.surname}, ${editedItem.author.name}`"
                                                        :items="authors"
                                                        item-text="surname"
                                                        item-value=""
                                                        label="Select"
                                                        persistent-hint
                                                        return-object
                                                        single-line
                                                        color="rgb(148, 208, 187)"
                                                    ></v-select>
                                                </v-col>
                                            </v-row>
                                        </v-container>
                                    </v-card-text>

                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn color="rgb(148, 208, 187)" text @click="close">Cancel</v-btn>
                                        <v-btn color="rgb(148, 208, 187)" text @click="save">Save</v-btn>
                                    </v-card-actions>
                                </v-card>

                            </v-dialog>
                        </v-toolbar>
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <v-icon
                            small
                            class="mr-2"
                            @click="editItem(item)"
                        >
                            mdi-pencil
                        </v-icon>
                        <v-icon
                            small
                            @click="deleteItem(item)"
                        >
                            mdi-delete
                        </v-icon>
                    </template>
                    <template v-slot:no-data>
                        <v-btn color="primary" @click="initialize">Reset</v-btn>
                    </template>
                </v-data-table>
            </div>
        </v-app>
    </div>
</template>

<script>
    export default {
        data: () => ({
            dialog: false,
            headers: [
                { text: 'Book title', align: 'start', value: 'title',},
                { text: 'Author', value: 'author.surname' },
                { text: 'Is borrowed', value: 'is_borrowed' },
                { text: 'Actions', value: 'actions', sortable: false },
            ],
            items: [],
            authors: [],
            editedIndex: -1,
            editedItem: {
                title: '',
                is_borrowed: 0,
                author: {
                    name: '',
                    surname:''
                },
            },
            defaultItem: {
                title: '',
                is_borrowed: 0,
                author: {
                    name: '',
                    surname: ''
                },
            },
        }),
        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'Add new book' : 'Edit book'
            },
        },
        watch: {
            dialog (val) {
                val || this.close()
            },
        },
        created () {
            this.initialize()
        },
        methods: {
            initialize () {
                axios
                    .get('/api/books')
                    .then(response => (
                        this.items = response.data
                    ))
                    .catch(error => console.log(error))
                axios
                    .get('/api/authors')
                    .then(response => (
                        this.authors = response.data
                    ))
                    .catch(error => console.log(error))
            },

            editItem (item) {
                this.editedIndex = this.items.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },

            deleteItem (item) {
                axios.patch('/api/books/delete', {id:item.id})
                    .then(res => {
                        console.log(res)
                    })
                this.initialize()
                const index = this.items.indexOf(item)
                this.items.splice(index, 1)
            },

            close () {
                this.dialog = false
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                })
            },
            /*
             *      save or update item
             * */
            save () {
                this.editedItem.is_borrowed == false ? this.editedItem.is_borrowed = 0 : this.editedItem.is_borrowed = 1
                if (this.editedIndex === -1) {
                    axios.post('/api/books/create', this.editedItem)
                        .then(res => {
                            console.log(res)
                        })
                } else {
                    axios.put('/api/books/update', this.editedItem)
                        .then(res => {
                            console.log(res)
                        })
                }
                this.initialize()
                if (this.editedIndex > -1) {
                    Object.assign(this.items[this.editedIndex], this.editedItem)
                } else {
                    this.items.push(this.editedItem)
                }
                this.close()
            },
        },
    }
</script>
<style>
    .table-container{
        width:90vw;
        margin:25px 0px 0px 0px;
    }
    .auto-height-container{
        flex: 0 1 auto;
    }
</style>

