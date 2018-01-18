/**
 * @date:    2018-01-19
 * @file:    upload.js
 * @author:  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

import axios from 'axios'

// Workaround for sending mixed file/form input requests
export const makeUploadFilePromise = (payload, updateObj, url) => {
  return new Promise((resolve, reject) => {
    // No file, resolve instantly
    if (! payload.file) {
      return resolve()
    }

    let data = new FormData()
    data.append('file', payload.file)

    axios.post(url, data)
      .then(response => {
        if (! response.data.success) {
          console.warn('Could not store file!', response.data)
          resolve(null)
        }
        console.log('File was stored', response.data)
        resolve(response.data)
      })
      .catch(e => reject(e))
  })
}
