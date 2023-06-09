<template>
  <div>
    <Head title="Tasks" />
    <h1 class="mb-8 text-3xl font-bold">Tasks</h1>
    <div class="flex items-center justify-between mb-6">
      <Link class="btn-indigo" href="/task/create">
        <span>Create</span>
        <span class="hidden md:inline">&nbsp;Task</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <thead>
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 px-6">Name</th>
            <th class="pb-4 pt-6 px-6">Description</th>
            <th class="pb-4 pt-6 px-6">Status</th>
            <th class="pb-4 pt-6 px-6" colspan="2">Date created</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="task in tasks.data" :key="task.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/task/${task.id}/edit`">
                {{ task.name }}
                <icon v-if="task.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400" />
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/task/${task.id}/edit`" tabindex="-1">
                {{ task.description }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/task/${task.id}/edit`" tabindex="-1">
                {{ task.status }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/task/${task.id}/edit`" tabindex="-1">
                {{ task.created_at }}
              </Link>
            </td>
            <td class="w-px border-t">
              <Link class="flex items-center px-4" :href="`/task/${task.id}/edit`" tabindex="-1">
                <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
              </Link>
            </td>
          </tr>
          <tr v-if="tasks.data.length === 0">
            <td class="px-6 py-4 border-t" colspan="4">No tasks found.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <pagination class="mt-6" :links="tasks.links" />
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'

export default {
  components: {
    Head,
    Icon,
    Link,
    Pagination,
  },
  layout: Layout,
  props: {
    tasks: Object,
  },
  data() {
    return {}
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/task', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
