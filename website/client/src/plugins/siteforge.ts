import * as blocks from 'siteforge/blocks';

export default (app) => {
  Object.keys(blocks).map(block => {
    app.component(block, blocks[block]);
  })
}
